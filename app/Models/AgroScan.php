<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgroScan extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'raw_text',
        'cnpj_emitente',
        'cnpj_comprador',
        'valor_total',
        'data_emissao',
        'empresa_autorizada',
        'dados_receita_emitente',
        'dados_receita_comprador',
        'parecer_texto',
        'status',
        'error_message',
    ];

    protected $casts = [
        'empresa_autorizada'      => 'boolean',
        'dados_receita_emitente'  => 'array',
        'dados_receita_comprador' => 'array',
        'data_emissao'            => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
