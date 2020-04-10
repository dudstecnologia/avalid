<?php

namespace App\Services;

use App\Models\Avaliacao;
use App\Models\Questao;
use Exception;
use Illuminate\Support\Facades\Hash;
use Throwable;

class QuestaoService
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

    public static function store(Avaliacao $avaliacao, $request)
    {
        try {
            $questoes = array();
            foreach($request['questoes'] as $q) {
                $questoes[] = $avaliacao->questoes()->create($q);
            }
            return $questoes;
        } catch (Throwable $th) {
            throw new Exception($th->getMessage());
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
