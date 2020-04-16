<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    protected $fillable = [
        'titulo',
        'pergunta',
        'tipo',
        'obrigatoria'
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }
}
