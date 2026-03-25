<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CnpjCache extends Model
{
    protected $table = 'cnpj_cache';

    public $timestamps = false;

    protected $fillable = [
        'cnpj',
        'dados',
        'consultado_em',
    ];

    protected $casts = [
        'dados'         => 'array',
        'consultado_em' => 'datetime',
    ];
}
