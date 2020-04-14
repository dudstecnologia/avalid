<?php

namespace App\Services;

use App\Models\Avaliacao;
use App\Models\AvaliacaoFuncionario;
use App\Models\Questao;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AvaliacaoRespostaService
{
    /*
    public static function show($id)
    {
        try {
            return User::findOrFail($id);
        } catch (Throwable $th) {
            return null;
        }
    }
    */

    public static function store($request)
    {
        try {
            DB::beginTransaction();
            $avaliacaoFuncionario = AvaliacaoFuncionario::findOrFail($request->avaliacaoFuncionario);
            $avaliado = User::findOrFail($request->avaliado);

            $respostas = $request->except(['avaliacaoFuncionario', 'avaliado']);

            foreach($respostas as $key => $value) {
                $avaliacaoFuncionario->avaliacaoRespostas()->create([
                    'resposta' => $value,
                    'questao_id' => $key,
                    'avaliador_id' => Auth::user()->id,
                    'avaliado_id' => $avaliado->id
                ]);
            }
            DB::commit();
            return array(
                'status' => true,
                'avaliado' => ['avaliado' => $avaliado->id],
                'msg' => 'Avaliação realizada com sucesso'
            );
        } catch (Throwable $th) {
            DB::rollBack();
            return array(
                'status' => false,
                'msg' => 'Erro ao realizar a avaliação',
                'erro' => $th->getMessage()
            );
        }
    }
    
    /*
    public static function update(Avaliacao $avaliacao, $request)
    {
        try {
            $questoes = array();
            $avaliacao->questoes()->delete();
            foreach($request['questoes'] as $q) {
                $questoes[] = $avaliacao->questoes()->create($q);
            }
            return $questoes;
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    
    public static function alterarStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => $user->status ? false : true]);
            return $user;
        } catch (Throwable $e) {
            return null;
        }
    }
    */
}
