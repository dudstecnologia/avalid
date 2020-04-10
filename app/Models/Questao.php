<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    protected $fillable = [
        'pergunta',
        'tipo',
        'range',
        'obrigatoria'
    ];

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }
}
