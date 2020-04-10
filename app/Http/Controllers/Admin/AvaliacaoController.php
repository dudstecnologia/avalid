<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AvaliacaoDataTable;
use App\Http\Controllers\Controller;
use App\Services\DatatableService;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
