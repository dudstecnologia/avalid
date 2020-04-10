<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $fillable = [
        'titulo',
        'status'
    ];

    public function questoes()
    {
        return $this->hasMany(Questao::class);
    }
}
