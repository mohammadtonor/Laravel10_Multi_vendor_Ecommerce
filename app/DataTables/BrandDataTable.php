<?php

namespace App\DataTables;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BrandDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($query) {
            $action = "<div class='d-flex'>
                <a href='".route('admin.brand.edit', $query->id)."' class='btn btn-primary'><i class='far fa-edit'></i></a>
                <a href='".route('admin.brand.destroy', $query->id)."' class='btn btn-danger ml-2 delete-item'><i class='far fa-trash-alt'></i></a>
           </div>";
           return $action;
        })
        ->addColumn('logo', function($query) {
            return $img = "<img width=100  height=50 src='".asset($query->logo ?? "backend/assets/img/news/img01.jpg")."'> </img>";
        })
        ->addColumn('status', function ($query) {
            if($query->status == 1) {
                $status = '<label class="custom-switch mt-2">
                    <input type="checkbox" name="custom-switch-checkbox" checked data-id="'.$query->id.'" class="custom-switch-input change-status">
                    <span class="custom-switch-indicator"></span>
                </label>';
            } else {
                $status = '<label class="custom-switch">
                    <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input change-status">
                    <span class="custom-switch-indicator"></span>
                </label>';
            }
            return $status;
        })
        ->addColumn('is_featured', function ($query) {
            if($query->is_featured == 1) {
                $is_featured = '<i class="badge badge-success">Yes</i>';
            } else {
                $is_featured = '<i class="badge badge-danger">No</i>';
            }
            return $is_featured;
        })
        ->rawColumns(['action', 'logo', 'status', 'is_featured'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Brand $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('brand-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(50),
            Column::make('logo'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('is_featured'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Brand_' . date('YmdHis');
    }
}
