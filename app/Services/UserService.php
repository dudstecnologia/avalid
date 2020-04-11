<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UserService
{
    public static function admin() {
        if (Auth::user()) {
            return Auth::user()->admin;
        }

        return false;
    }

    public static function show($id)
    {
        try {
            return User::findOrFail($id);
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function store($request)
    {
        try {
            return User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'admin' => $request['admin'],
                'status' => $request['status']
            ]);
        } catch (Throwable $th) {
            return null;
        }
    }

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
        } catch (Throwable $th) {
            return null;
        }
    }

    public static function listarAvaliados()
    {
        try {
            $avaliados = User::whereStatus(true)
                            ->whereAdmin(false)
                            ->whereNotIn('id', [Auth::user()->id])
                            ->get();
            return array(
                'status' => true,
                'avaliados' => $avaliados
            );
        } catch (Throwable $th) {
            return array(
                'status' => false,
                'msg' => 'Erro ao listar os avaliados',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function updateUserFuncionario($request)
    {
        try {
            if (isset($request['foto']) && $request['foto']) {
                $request['foto'] = self::uploadImagem($request['foto']);
            } else {
                unset($request['foto']);
            }

            $request['password'] = Hash::make($request['password']);

            auth()->user()->update($request);

            return array(
                'status' => true,
                'msg' => 'Dados de perfil atualizados com sucesso'
            );
        } catch (Throwable $th) {
            dd($th->getMessage());
            return array(
                'status' => false,
                'msg' => 'Erro ao atualizar os dados do perfil',
                'erro' => $th->getMessage()
            );
        }
    }

    public static function uploadImagem($imgBase64)
    {
        $pasta =  '/img/';
        $nomeImagem = auth()->user()->id . '.png';
        $imagem = substr($imgBase64, strpos($imgBase64, ',') + 1);
        $status = file_put_contents(public_path() . $pasta . $nomeImagem, base64_decode($imagem));
        
        return $status ? $pasta . $nomeImagem : null;
    }
}
