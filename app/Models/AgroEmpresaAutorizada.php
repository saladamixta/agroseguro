<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgroEmpresaAutorizada extends Model
{
    protected $table = 'agro_empresas_autorizadas';

    protected $fillable = [
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'uf',
        'municipio',
        'registro_mapa',
        'ativa',
    ];

    protected $casts = [
        'ativa' => 'boolean',
    ];
}
