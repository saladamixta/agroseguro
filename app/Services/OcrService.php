<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class OcrService
{
    /**
     * Lê o arquivo do disco "public", manda pro Azure Document Intelligence
     * e devolve o texto bruto extraído.
     */
    public function extractTextFromStorage(string $storagePath): string
    {
        // Config do Azure OCR (config/services.php + .env)
        $azureKey = config('services.azure_ocr.key') ?? env('AZURE_OCR_KEY');
        $azureEndpoint = config('services.azure_ocr.endpoint') ?? env('AZURE_OCR_ENDPOINT');

        if ($azureEndpoint) {
            $azureEndpoint = rtrim($azureEndpoint, '/');
        }

        if (!$azureKey || !$azureEndpoint) {
            throw new \RuntimeException(
                'Azure OCR não configurado (services.azure_ocr.endpoint / key).'
            );
        }

        // 1) Lê o arquivo salvo pelo AgroScan (disco "public")
        $fileContent = Storage::disk('public')->get($storagePath);

        // Descobre o mime; se não souber, usa binário genérico
        $mime = Storage::disk('public')->mimeType($storagePath) ?: 'application/octet-stream';

        // 2) Endpoint do Document Intelligence
        $urlAnalyze = $azureEndpoint
            . '/documentintelligence/documentModels/prebuilt-receipt:analyze'
            . '?api-version=2024-11-30';

        Log::info('Azure OCR - Enviando para analyze', [
            'path' => $storagePath,
            'mime' => $mime,
            'endpoint' => $urlAnalyze,
        ]);

        // 3) POST assíncrono mandando o BINÁRIO do arquivo (NÃO em JSON!)
        $postResponse = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Ocp-Apim-Subscription-Key' => $azureKey,
                'Content-Type'              => $mime,
            ])
            ->withBody($fileContent, $mime)
            ->post($urlAnalyze);

        if ($postResponse->failed()) {
            Log::error('Azure OCR analyze falhou', [
                'status' => $postResponse->status(),
                'body'   => $postResponse->body(),
            ]);

            throw new \RuntimeException(
                'Falha ao enviar o documento para o Azure OCR (HTTP '
                . $postResponse->status() . ').'
            );
        }

        // 4) Recupera o Operation-Location para fazer polling
        $operationLocation = $postResponse->header('Operation-Location');

        if (!$operationLocation) {
            Log::error('Azure OCR: Operation-Location ausente', [
                'body' => $postResponse->body(),
            ]);

            throw new \RuntimeException(
                'Resposta inesperada do Azure OCR (sem Operation-Location).'
            );
        }

        Log::info('Azure OCR - OperationLocation recebido', [
            'operation_location' => $operationLocation,
        ]);

        // 5) Polling até o status ficar "succeeded"
        //    (aqui aumentei o tempo total de espera!)
        $maxTentativas = 25;   // até ~ 30 segundos de espera
        $esperaMs      = 1200; // 1,2s entre tentativas

        $analyzeResult = null;

        for ($i = 0; $i < $maxTentativas; $i++) {
            usleep($esperaMs * 1000);

            $getResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Ocp-Apim-Subscription-Key' => $azureKey,
                ])
                ->get($operationLocation);

            if ($getResponse->failed()) {
                Log::warning('Azure OCR get-analyze falhou', [
                    'tentativa' => $i + 1,
                    'status'    => $getResponse->status(),
                    'body'      => $getResponse->body(),
                ]);
                continue;
            }

            $resultJson = $getResponse->json();
            $status     = $resultJson['status'] ?? null;

            Log::info('Azure OCR polling', [
                'tentativa' => $i + 1,
                'status'    => $status,
            ]);

            if ($status === 'running' || $status === 'notStarted') {
                // ainda processando, segue o loop
                continue;
            }

            if ($status === 'succeeded') {
                $analyzeResult = $resultJson['analyzeResult'] ?? null;
                break;
            }

            // status "failed" ou qualquer outro
            Log::error('Azure OCR retornou status inesperado', [
                'status' => $status,
                'body'   => $getResponse->body(),
            ]);

            throw new \RuntimeException(
                'Azure OCR não conseguiu processar o documento (status '
                . ($status ?? 'desconhecido') . ').'
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
            Log::error('Azure OCR não retornou texto', [
                'analyzeResult_snippet' => substr(
                    json_encode($analyzeResult, JSON_UNESCAPED_UNICODE),
                    0,
                    500
                ),
            ]);

            throw new \RuntimeException(
                'Azure OCR não retornou texto legível.'
            );
        }

        Log::info('Azure OCR - texto extraído', [
            'len'  => strlen($textoBruto),
            'path' => $storagePath,
        ]);

        return $textoBruto;
    }
}
