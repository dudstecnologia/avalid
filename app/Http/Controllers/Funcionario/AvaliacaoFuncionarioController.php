<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Services\AvaliacaoFuncionarioService;
use App\Services\AvaliacaoRespostaService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AvaliacaoFuncionarioController extends Controller
{
    public function verificaAvaliacao()
    {
        $avfunc = AvaliacaoFuncionarioService::verificaAvaliacao();

        return $avfunc['status'] ? response($avfunc, 200) : response($avfunc, 400);
    }

    public function listaAvaliados($avaliacao_funcionario)
    {
        $avaliados = UserService::listarAvaliados($avaliacao_funcionario);

        return $avaliados['status'] ? response($avaliados, 200) : response($avaliados, 400);
    }

    public function store(Request $request)
    {
        $questoes = AvaliacaoRespostaService::store($request);

        if ($questoes['status']) {
            return Redirect::route('dashboard')
                        ->with('success', $questoes['msg'])
                        ->withMessage($questoes['avaliado']);
		}
		
		return Redirect::back()->with('error', $questoes['msg']);
    }
}
