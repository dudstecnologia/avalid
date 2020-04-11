<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Services\AvaliacaoFuncionarioService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AvaliacaoFuncionarioController extends Controller
{
    public function verificaAvaliacao()
    {
        $avfunc = AvaliacaoFuncionarioService::verificaAvaliacao();

        return $avfunc['status'] ? response($avfunc, 200) : response($avfunc, 401);
    }

    public function listaAvaliados()
    {
        $avaliados = UserService::listarAvaliados();

        return $avaliados['status'] ? response($avaliados, 200) : response($avaliados, 401);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
