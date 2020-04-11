<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFuncionarioRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Funcionario/Index', [
            'user' => Auth::user()
        ]);
    }

    public function store(UserFuncionarioRequest $request)
    {
        $user = UserService::updateUserFuncionario($request->all());

        if ($user['status']) {
            return Redirect::route('funcionario.user.index')
                        ->with('success', $user['msg']);
		}
		
		return Redirect::back()->with('error', $user['msg']);
    }
}
