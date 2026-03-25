<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CnpjService
{
    /**
     * Consulta dados do CNPJ na API pública (ex.: https://receitaws.com.br/v1/cnpj/{cnpj})
     *
     * Retorna o array JSON completo da API quando "status" = "OK",
     * ou null em caso de erro.
     */
    public function getDados(?string $cnpj): ?array
    {
        if (!$cnpj) {
            return null;
        }

        $endpoint = rtrim(config('services.cnpj_api.endpoint'), '/');
        if (!$endpoint) {
            Log::error('CNPJ_API endpoint não configurado (services.cnpj_api.endpoint).');
            return null;
        }

        // garante só números
        $cnpjNumerico = preg_replace('/\D/', '', $cnpj);

        try {
            $response = Http::acceptJson()->get($endpoint . '/' . $cnpjNumerico);

            if ($response->failed()) {
                Log::error('Falha ao consultar CNPJ na ReceitaWS', [
                    'cnpj'   => $cnpjNumerico,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return null;
            }

            $json = $response->json();

            // ReceitaWS normalmente usa "status": "OK" / "ERROR"
            if (!is_array($json) || ($json['status'] ?? null) !== 'OK') {
                Log::warning('ReceitaWS retornou status != OK', [
                    'cnpj' => $cnpjNumerico,
                    'json' => $json,
                ]);

                return null;
            }

            return $json;
        } catch (\Throwable $e) {
            Log::error('Exceção ao consultar ReceitaWS', [
                'cnpj'  => $cnpjNumerico,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
