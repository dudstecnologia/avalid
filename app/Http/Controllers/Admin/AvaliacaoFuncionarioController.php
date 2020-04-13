<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AvaliacaoFuncionarioService;

class AvaliacaoFuncionarioController extends Controller
{
    public function listarAvaliacoes()
    {
        $retorno = AvaliacaoFuncionarioService::listarAvaliacoesAdmin();

		return $retorno['status'] ? response($retorno, 200) : response($retorno, 400);
    }
}
