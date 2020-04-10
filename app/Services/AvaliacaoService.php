<?php

namespace App\Services;

use App\Models\Avaliacao;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AvaliacaoService
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
    /*
    public static function update($request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if (isset($request['password'])) {
                $request['password'] = Hash::make($request['password']);
            }

            $user->update($request);
            return $user;
        } catch (Throwable $th) {
            return null;
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
