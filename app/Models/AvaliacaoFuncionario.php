<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoFuncionario extends Model
{
    protected $fillable = [
        'periodo',
        'avaliacao_id'
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }
}
