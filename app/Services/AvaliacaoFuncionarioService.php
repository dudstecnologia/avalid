<?php

namespace App\Services;

use App\Models\Avaliacao;
use App\Models\AvaliacaoFuncionario;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AvaliacaoFuncionarioService
{
    public static function listarAvaliacoesAdmin()
    {
        try {
            $avfunc = AvaliacaoFuncionario::join('avaliacaos', 'avaliacaos.id', 'avaliacao_funcionarios.avaliacao_id')
                        ->whereDate('periodo', '>=', Carbon::now()->modify('-4 months'))
                        ->select(
                            'avaliacao_funcionarios.id as avaliacao_funcionario', 
                            'avaliacao_funcionarios.periodo as periodo', 
                            'avaliacao_funcionarios.avaliacao_id as avaliacao',
                            'avaliacaos.titulo as titulo_avaliacao',
                            'avaliacao_funcionarios.status as status',
                            DB::raw('(select COUNT(questaos.id) from questaos where questaos.avaliacao_id = avaliacaos.id) questoes')
                        )
                        ->orderBy('avaliacao_funcionario', 'DESC')
                        ->get();

            return array(
                'status' => true,
                'avaliacoesFuncionarios' => $avfunc
            );
        } catch (Throwable $th) {
            return array(
                'status' => false,
                'msg' => 'Erro ao listar as avaliações',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function verificaAvaliacao()
    {
        try {
            $avfunc = AvaliacaoFuncionario::whereStatus(true)->first();

            if (!$avfunc) {
                return array(
                    'status' => false,
                    'msg' => 'Não existe avaliação disponível'
                );
            }

            return array(
                'status' => true,
                'avaliacaoFuncionario' => $avfunc,
                'avaliacao' => $avfunc->avaliacao,
                'questoes' => $avfunc->avaliacao->questoes
            );
        } catch (Throwable $th) {
            return array(
                'status' => false,
                'msg' => 'Erro ao verificar avaliações',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function store($id)
    {
        try {
            $mesPassado = Carbon::now()->modify('-1 months');

            $verificaAvaliacao = AvaliacaoFuncionario::whereAvaliacaoId($id)
                                    ->whereYear('periodo', '=', Carbon::now()->year)
                                    ->whereMonth('periodo', '=', $mesPassado->month)
                                    ->count();

            if ($verificaAvaliacao > 0) {
                return array(
                    'status' => false,
                    'msg' => 'Esta avaliação já foi liberada para este período'
                );
            }

            $avaliacao = Avaliacao::findOrFail($id);
            
            $avaliacao->avaliacaoFuncionarios()->create([
                'periodo' => $mesPassado
            ]);

            return array(
                'status' => true,
                'msg' => 'Avaliação liberada com sucesso',
            );
        } catch (Throwable $th) {

            return array(
                'status' => false,
                'msg' => 'Erro ao liberar a avaliação',
                'erro' => $th->getMessage(),
            );
        }
    }
}
