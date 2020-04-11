<?php

namespace App\Services;

use App\Models\Avaliacao;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AvaliacaoService
{
    public static function show($id)
    {
        try {
            return Avaliacao::findOrFail($id);
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function store($request)
    {
        try {
            DB::beginTransaction();
            $avaliacao = Avaliacao::create(Arr::except($request, ['questoes']));
            $questoes = QuestaoService::store($avaliacao, Arr::only($request, ['questoes']));
            DB::commit();
            return array(
                'status' => true,
                'msg' => 'Avaliação salva com sucesso',
                'avalicao' => $avaliacao,
                'questoes' => $questoes,
            );
        } catch (Throwable $th) {
            DB::rollBack();
            return array(
                'status' => false,
                'msg' => 'Erro ao salvar a avaliação',
                'erro' => $th->getMessage(),
            );
        }
    }
    
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
}
