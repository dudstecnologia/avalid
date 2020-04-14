<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\DatatableService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    private $userDataTable;

    public function __construct(UserDataTable $userDataTable)
    {
        $this->userDataTable = $userDataTable;
    }

    public function datatable()
    {
        return DatatableService::datatable($this->userDataTable);
    }

    public function index()
    {
        return Inertia::render('User/Index');
    }

    public function show($id)
	{
		$user = UserService::show($id);

		return $user ? response($user, 200) : response('', 401);
	}

    public function store(UserRequest $request)
    {
		$user = UserService::store($request->all());
		
		if ($user) {
			return Redirect::route('admin.user.index')->with('success', 'Usuário salvo com sucesso');
		}
		
		return Redirect::back()->with('error', 'Erro ao salvar o usuário');
	}
	
	public function update(UserRequest $request, $id)
	{
		$user = UserService::update($request->all(), $id);
		
		if ($user) {
			return Redirect::route('admin.user.index')->with('success', 'Usuário atualizado com sucesso');
		}
		
		return Redirect::back()->with('error', 'Erro ao atualizar o usuário');
	}

	public function alterarStatus($id)
    {
        $user = UserService::alterarStatus($id);
        return $user ? response($user, 200) : response('', 401);
    }

    public function listarAvaliados($avaliacao_funcionario)
    {
        $retorno = UserService::listarAvaliadosAdmin($avaliacao_funcionario);
        
        return $retorno['status'] ? response($retorno, 200) : response($retorno, 400);
    }
}
