<?php

namespace App\Services;

class NotaFiscalParser
{
    public function parse(string $rawText): array
    {
        // Aqui entra a lógica que você já usa no app antigo
        // Por enquanto, vou pegar apenas um CNPJ e deixar o resto null.

        $cnpjEmitente = $this->findFirstCnpj($rawText);

        return [
            'cnpj_emitente'  => $cnpjEmitente,
            'cnpj_comprador' => null,
            'valor_total'    => null,
            'data_emissao'   => null,
        ];
    }

    protected function findFirstCnpj(string $text): ?string
    {
        // Formato xx.xxx.xxx/xxxx-xx
        if (preg_match('/\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}/', $text, $m)) {
            return $m[0];
        }

        // Só números (14 dígitos)
        if (preg_match('/\d{14}/', $text, $m)) {
            return $m[0];
        }

        return null;
    }
}
