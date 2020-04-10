<?php

namespace App\DataTables;

use App\Models\Avaliacao;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AvaliacaoDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($avaliacao) {
                return [
                    [
                        'titulo' => 'Editar',
                        'classe' => 'fa fa-edit',
                        'funcao' => 'editarAvaliacao',
                        'id' => $avaliacao->id
                    ],
                    [
                        'titulo' => 'Alterar Status',
                        'classe' => 'fa fa-toggle-on',
                        'funcao' => 'alterarStatus',
                        'id' => $avaliacao->id
                    ],
                    [
                        'titulo' => 'Excluir',
                        'classe' => 'fa fa-trash',
                        'funcao' => 'excluirAvaliacao',
                        'id' => $avaliacao->id
                    ]
                ];
            })
            ->addColumn('perguntas', function($avaliacao) {
                return $avaliacao->questoes->count();
            })
            ->editColumn('status', function ($avaliacao) {
                return $avaliacao->status ? 'Ativa' : 'Inativa';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Avaliacao $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Avaliacao $model)
    {
        return $model->select('id', 'titulo', 'status');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('avaliacao-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('titulo')->title('Título'),
            Column::make('perguntas')->title('N° de Perguntas'),
            Column::make('status')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Avaliacao_' . date('YmdHis');
    }
}
