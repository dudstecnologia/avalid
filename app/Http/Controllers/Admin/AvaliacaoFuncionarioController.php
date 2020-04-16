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

    public function finalizarAvaliacao($avaliacao_funcionario)
    {
        $retorno = AvaliacaoFuncionarioService::finalizarAvaliacao($avaliacao_funcionario);

        return $retorno['status'] ? response($retorno, 200) : response($retorno, 400);
    }

    public function relatorioCompleto($avaliacao_funcionario)
    {
        $retorno = AvaliacaoFuncionarioService::relatorioCompleto($avaliacao_funcionario);

        return $retorno['status'] ? response($retorno, 200) : response($retorno, 400);
    }
}
