<?php

namespace App\Services;

use App\User;

class UserService
{
    public static function usersPagination()
    {
        return User::select('id', 'name', 'email', 'admin')
                    ->paginate(10);
    }
}
