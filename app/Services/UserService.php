<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
}
