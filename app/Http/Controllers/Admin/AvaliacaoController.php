<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AvaliacaoDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvaliacaoRequest;
use App\Services\AvaliacaoService;
use App\Services\DatatableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AvaliacaoController extends Controller
{
    private $avaliacaoDataTable;

    public function __construct(AvaliacaoDataTable $avaliacaoDataTable)
    {
        $this->avaliacaoDataTable = $avaliacaoDataTable;
    }

    public function datatable()
    {
        return DatatableService::datatable($this->avaliacaoDataTable);
    }

    public function index()
    {
        return Inertia::render('Avaliacao/Admin/Index');
    }

    public function create()
    {
        return Inertia::render('Avaliacao/Admin/Form');
    }

    public function store(AvaliacaoRequest $request)
    {
        $avaliacao = AvaliacaoService::store($request->all());
		
		if ($avaliacao['status']) {
			return Redirect::route('admin.avaliacao.index')->with('success', $avaliacao['msg']);
		}
		
		return Redirect::back()->with('error', $avaliacao['msg']);
    }

    public function show($id)
    {
        $avaliacao = AvaliacaoService::show($id);

        if ($avaliacao) {
            return Inertia::render('Avaliacao/Admin/Form', [
                'avaliacao' => $avaliacao,
                'questoes' => $avaliacao->questoes
            ]);
        }

        return Redirect::back()->with('error', 'Erro ao selecionar a Avaliação');
    }

    public function update(AvaliacaoRequest $request, $id)
    {
        $avaliacao = AvaliacaoService::update($request->all(), $id);
		
		if ($avaliacao['status']) {
			return Redirect::route('admin.avaliacao.index')->with('success', $avaliacao['msg']);
		}
		
		return Redirect::back()->with('error', $avaliacao['msg']);
    }
}
