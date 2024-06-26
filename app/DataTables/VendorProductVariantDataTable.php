<?php

namespace App\DataTables;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantDataTable extends DataTable
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
            return $editBtn = "<div class='d-flex'>
                <a href='".route('vendor.products-variant-item.index', ['productId' => $query->product_id, "variantId" => $query->id])."' class='btn btn-info' style='margin-right: 5px; color: #fff;'><i class='far fa-edit'></i> Variant Items</a>
                <a href='".route('vendor.products-variant.edit', $query->id)."' class='btn btn-primary'><i class='far fa-edit'></i></a>
                <a href='".route('vendor.products-variant.destroy', $query->id)."' class='btn btn-danger mr-2 delete-item' style='margin-left: 10px;'><i class='far fa-trash-alt'></i></a>
            </div>";
        })
        ->addColumn('status', function ($query) {
            if($query->status == 1) {
                $status = '<div class="form-check form-switch" >
                    <input style="border-radius: 10px !important;  width: 40px !important;" class="form-check-input change-status" data-id="'.$query->id.'" type="checkbox" id="flexSwitchCheckChecked" checked>
                </div>';
            } else {
                $status = '<div class="form-check form-switch" >
                    <input style="border-radius: 10px !important;  width: 40px !important;" class="form-check-input change-status" data-id="'.$query->id.'" type="checkbox" id="flexSwitchCheckChecked">
                </div>';
            }
            return $status;
        })
        ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariant $model): QueryBuilder
    {
        return $model->where('product_id', request()->product)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariant-table')
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
            Column::make('id')->width(40),
            Column::make('name'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(250)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductVariant_' . date('YmdHis');
    }
}
