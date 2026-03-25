<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class OcrService
{
    /**
     * Lê o arquivo do disco "public", manda para o Azure Document Intelligence
     * e devolve o texto bruto extraído.
     */
    public function extractTextFromStorage(string $storagePath): string
    {
        // Sempre usar config() em produção
        $azureKey = config('services.azure_ocr.key');
        $azureEndpoint = config('services.azure_ocr.endpoint');

        if ($azureEndpoint) {
            $azureEndpoint = rtrim($azureEndpoint, '/');
        }

        if (empty($azureKey) || empty($azureEndpoint)) {
            throw new \RuntimeException(
                'Azure OCR não configurado. Verifique services.azure_ocr.endpoint e services.azure_ocr.key.'
            );
        }

        if (!Storage::disk('public')->exists($storagePath)) {
            throw new \RuntimeException(
                'Arquivo não encontrado no disco public: ' . $storagePath
            );
        }

        // 1) Lê o arquivo salvo no disco "public"
        $fileContent = Storage::disk('public')->get($storagePath);

        // Descobre o mime; se não souber, usa binário genérico
        $mime = Storage::disk('public')->mimeType($storagePath) ?: 'application/octet-stream';

        // 2) Endpoint do Document Intelligence
        $urlAnalyze = $azureEndpoint
            . '/documentintelligence/documentModels/prebuilt-receipt:analyze'
            . '?api-version=2024-11-30';

        Log::info('Azure OCR - enviando arquivo para analyze', [
            'path' => $storagePath,
            'mime' => $mime,
            'endpoint' => $urlAnalyze,
        ]);

        // 3) POST assíncrono mandando o binário do arquivo
        $postResponse = Http::timeout(120)
            ->connectTimeout(30)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'Ocp-Apim-Subscription-Key' => $azureKey,
                'Content-Type' => $mime,
            ])
            ->withBody($fileContent, $mime)
            ->post($urlAnalyze);

        if ($postResponse->failed()) {
            Log::error('Azure OCR analyze falhou', [
                'status' => $postResponse->status(),
                'body' => $postResponse->body(),
            ]);

            throw new \RuntimeException(
                'Falha ao enviar o documento para o Azure OCR (HTTP ' . $postResponse->status() . ').'
            );
        }

        // 4) Recupera o Operation-Location para polling
        $operationLocation = $postResponse->header('Operation-Location');

        if (!$operationLocation) {
            Log::error('Azure OCR: Operation-Location ausente', [
                'body' => $postResponse->body(),
            ]);

            throw new \RuntimeException(
                'Resposta inesperada do Azure OCR: Operation-Location não foi retornado.'
            );
        }

        Log::info('Azure OCR - operation location recebido', [
            'operation_location' => $operationLocation,
        ]);

        // 5) Polling até concluir
        $maxTentativas = 25;
        $esperaMs = 1200;

        $analyzeResult = null;

        for ($i = 0; $i < $maxTentativas; $i++) {
            usleep($esperaMs * 1000);

            $getResponse = Http::timeout(120)
                ->connectTimeout(30)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'Ocp-Apim-Subscription-Key' => $azureKey,
                ])
                ->get($operationLocation);

            if ($getResponse->failed()) {
                Log::warning('Azure OCR polling falhou', [
                    'tentativa' => $i + 1,
                    'status' => $getResponse->status(),
                    'body' => $getResponse->body(),
                ]);
                continue;
            }

            $resultJson = $getResponse->json();
            $status = $resultJson['status'] ?? null;

            Log::info('Azure OCR polling', [
                'tentativa' => $i + 1,
                'status' => $status,
            ]);

            if ($status === 'running' || $status === 'notStarted') {
                continue;
            }

            if ($status === 'succeeded') {
                $analyzeResult = $resultJson['analyzeResult'] ?? null;
                break;
            }

            Log::error('Azure OCR retornou status inesperado', [
                'status' => $status,
                'body' => $getResponse->body(),
            ]);

            throw new \RuntimeException(
                'Azure OCR não conseguiu processar o documento (status ' . ($status ?? 'desconhecido') . ').'
            );
        }

        if (!$analyzeResult) {
            throw new \RuntimeException(
                'Timeout ao aguardar o resultado do Azure OCR.'
            );
        }

        // 6) Tenta pegar o texto bruto
        $textoBruto = $analyzeResult['content'] ?? null;

        // fallback: monta texto a partir das páginas/linhas
        if (!$textoBruto && isset($analyzeResult['pages'])) {
            $linhas = [];

            foreach ($analyzeResult['pages'] as $page) {
                if (!empty($page['lines'])) {
                    foreach ($page['lines'] as $line) {
                        $linhas[] = $line['content'] ?? '';
                    }
                }
            }

            $textoBruto = trim(implode("\n", $linhas));
        }

        if (!$textoBruto) {
            Log::error('Azure OCR não retornou texto legível', [
                'analyze_result_snippet' => substr(
                    json_encode($analyzeResult, JSON_UNESCAPED_UNICODE),
                    0,
                    1000
                ),
            ]);

            throw new \RuntimeException(
                'Azure OCR não retornou texto legível.'
            );
        }

        Log::info('Azure OCR - texto extraído com sucesso', [
            'path' => $storagePath,
            'len' => strlen($textoBruto),
        ]);

        return $textoBruto;
    }
}
