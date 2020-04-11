<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoResposta extends Model
{
    protected $fillable = [
        'resposta',
        'avaliacao_funcionario_id',
        'questao_id',
        'avaliador_id',
        'avaliado_id'
    ];
}
