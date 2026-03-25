<?php

namespace App\Services;

use App\Models\AgroEmpresaAutorizada;

class EmpresasAutorizadasService
{
    public function isAutorizada(?string $cnpj): ?bool
    {
        if (! $cnpj) {
            return null;
        }

        $cnpj = preg_replace('/\D/', '', $cnpj);

        $empresa = AgroEmpresaAutorizada::where('cnpj', $cnpj)->first();

        if (! $empresa) {
            return null; // não consta na base
        }

        return $empresa->ativa;
    }
}
