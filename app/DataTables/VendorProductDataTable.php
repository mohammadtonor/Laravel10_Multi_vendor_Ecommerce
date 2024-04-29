<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class VendorProductDataTable extends DataTable
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
                    <a href='".route('vendor.products.edit', $query->id)."' class='btn btn-primary'><i class='far fa-edit'></i></a>
                    <a href='".route('vendor.products.destroy', $query->id)."' class='btn btn-danger mr-2 delete-item' style='margin-left: 10px;'><i class='far fa-trash-alt'></i></a>
                    <div class='btn-group dropstart' style='margin-left: 5px;'>
                        <button type='button' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                        <i class='fas fa-cog'></i>
                        </button>
                        <ul class='dropdown-menu'>
                            <li><a class='dropdown-item has-icon' href='".route('vendor.product-image-gallery.index', ['product' => $query->id])."'>Image Gallery</a></li>
                            <li><a class='dropdown-item has-icon' href='".route('vendor.products-variant.index', ['product' => $query->id])."'>Variant</a></li>
                        </ul>
                    </div>
                </div>";
            })
            ->addColumn('thumb_image', function($query) {
                return $img = "<img width=100  height=50 src='".asset($query->thumb_image ?? "backend/assets/img/news/img01.jpg")."'> </img>";
            })
            ->addColumn('status', function ($query) {
                if($query->status == 1) {
                    $status = '<div class="form-check form-switch" >
                        <input style="border-radius: 10px !important;  width: 40px !important;" class="form-check-input check-status" data-id="'.$query->id.'" type="checkbox" id="flexSwitchCheckChecked" checked>
                    </div>';
                } else {
                    $status = '<div class="form-check form-switch" >
                        <input style="border-radius: 10px !important;  width: 40px !important;" class="form-check-input check-status" data-id="'.$query->id.'" type="checkbox" id="flexSwitchCheckChecked">
                    </div>';
                }
                return $status;
            })
            ->addColumn('product_type', function ($query) {
                switch($query->product_type) {
                    case 'new_arrival':
                        return '<i class="badge bg-success">New Arrival</i>';
                        break;
                    case 'featured_product':
                        return '<i class="badge bg-warning">Featured Product</i>';
                        break;
                    case 'top_product':
                        return '<i class="badge bg-info">Top Product</i>';
                        break;
                    case 'best_product':
                        return '<i class="badge bg-danger">Best Product</i>';
                        break;
                    default:
                        return '<i class="badge bg-dark">None</i>';
                        break;
                }
            })
            ->rawColumns(['thumb_image', 'action', 'product_type', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->where('vendor_id', Auth::user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproduct-table')
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
            Column::make('thumb_image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('product_type'),
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
        return 'VendorProduct_' . date('YmdHis');
    }
}
