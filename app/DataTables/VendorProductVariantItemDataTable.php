<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Hamcrest\Type\IsDouble;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantItemDataTable extends DataTable
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
                    <a href='".route('vendor.products-variant-item.edit', $query->id)."' class='btn btn-primary ml-2'><i class='far fa-edit'></i></a>
                    <a href='".route('vendor.products-variant-item.destroy', $query->id)."' class='btn btn-danger ml-2 delete-item'><i class='far fa-trash-alt'></i></a>
                </div>";
            })
            ->addColumn('is_default', function ($query) {
                if($query->is_default == 1) {
                    $isDefault = "<span class='badge badge-success'>Yes</span>";
                } else {
                    $isDefault = "<span class='badge badge-danger'>No</span>";
                }
                return $isDefault;
            })
            ->addColumn('variant_name', function ($query) {
                return $query->productVariant->name;
            })
            ->addColumn('is_default', function ($query) {
                if($query->is_default == 1) {
                    $isDefault =  '<i class="badge bg-success">Yes</i>';
                } else {
                    $isDefault =  '<i class="badge bg-danger">No</i>';
                }
                return $isDefault;

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
            ->rawColumns(['status', 'action', 'is_default',])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('product_variant_id', request()->variantId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariantitem-table')
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
            Column::make('id'),
            Column::make('name'),
            Column::make('variant_name'),
            Column::make('price'),
            Column::make('is_default'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductVariantItem_' . date('YmdHis');
    }
}
