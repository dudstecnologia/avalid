<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService
{
    public static function usersPagination()
    {
        return User::select('id', 'name', 'email', 'admin')
                    ->paginate(10);
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

    public static function show($id)
    {
        try {
            return User::findOrFail($id);
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
}
