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
    /*
    public static function show($id)
    {
        try {
            return Avaliacao::findOrFail($id);
        } catch (Throwable $th) {
            return null;
        }
    }
    */
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
            $avaliacao = Avaliacao::findOrFail($id);
            
            $avaliacao->avaliacaoFuncionarios()->create([
                'periodo' => Carbon::now()->modify('-1 months')
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
    
    /*
    public static function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $avaliacao = Avaliacao::findOrFail($id);
            $avaliacao->update(Arr::except($request, ['questoes']));
            $questoes = QuestaoService::update($avaliacao, Arr::only($request, ['questoes']));
            DB::commit();
            return array(
                'status' => true,
                'msg' => 'Avaliação atualizada com sucesso',
                'avalicao' => $avaliacao->refresh(),
                'questoes' => $questoes,
            );
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return array(
                'status' => false,
                'msg' => 'Erro ao atualizar a avaliação',
                'erro' => $th->getMessage(),
            );
        }
    }
    */
}
