<?php

namespace App\Services;

use App\Models\Avaliacao;
use App\Models\AvaliacaoFuncionario;
use App\Models\AvaliacaoResposta;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

use function PHPSTORM_META\map;

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
                            // 'avaliacao_funcionarios.avaliacao_id as avaliacao',
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

    public static function finalizarAvaliacao($avaliacao_funcionario)
    {
        try {
            $avFunc = AvaliacaoFuncionario::findOrFail($avaliacao_funcionario);
            $avFunc->update(['status' => $avFunc->status ? false : true]);

            return array(
                'status' => true,
                'msg' => 'Avaliação finalizada com sucesso'
            );
        } catch (Throwable $th) {
            
            return array(
                'status' => false,
                'msg' => 'Erro ao finalizar a avaliação',
                'erro' => $th->getMessage(),
            );
        }
    }

    public static function relatorioCompleto($avaliacao_funcionario)
    {
        try {
            $avFunc = AvaliacaoFuncionario::findOrFail($avaliacao_funcionario);

            $avaliados = User::whereAdmin(false)
                            ->whereDate('created_at', '<=', $avFunc->created_at)
                            ->select('id', 'name')
                            ->get();

            $resultado = array();

            foreach ($avaliados as $a) {
                $questoes = $avFunc->avaliacao->questoes()->whereTipo('multipla')->get();

                $notas = array();
                $total = 0;

                foreach ($questoes as $q) {
                    $nota = AvaliacaoResposta::whereAvaliacaoFuncionarioId($avFunc->id)
                                            ->whereQuestaoId($q->id)
                                            ->whereAvaliadoId($a->id)
                                            ->select(DB::raw('sum(resposta) as total'))
                                            ->first();

                    $media = $nota->total / ($avaliados->count() - 1);
                    $notas[$q->titulo] = $media;
                    $total += $media;
                }

                $resultado[] = array(
                    'nome' => $a->name,
                    'notas' => $notas,
                    'total' => $total
                );
            }

            return array(
                'status' => true,
                'resultado' => $resultado
            );
        } catch (Throwable $th) {
            
            return array(
                'status' => false,
                'msg' => 'Erro ao gerar o relatório',
                'erro' => $th->getMessage(),
            );
        }
    }
}
