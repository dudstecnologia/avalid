<?php

namespace App\Models;

use App\User;
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

    public function questao()
    {
        return $this->belongsTo(Questao::class);
    }

    public function avaliador()
    {
        return $this->belongsTo(User::class);
    }

    public function avaliado()
    {
        return $this->belongsTo(User::class);
    }
}
