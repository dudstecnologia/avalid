<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoFuncionario extends Model
{
    protected $fillable = [
        'periodo',
        'avaliacao_id'
    ];

    protected $dates = [
        'periodo',
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function avaliacaoRespostas()
    {
        return $this->hasMany(AvaliacaoResposta::class);
    }
}
