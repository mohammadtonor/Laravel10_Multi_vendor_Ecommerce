<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index (FlashSaleItemDataTable $datatable) {
        $flashSale = FlashSale::first();
        $products = Product::where(function ($query) {
            $query->where('is_approved', 1)
            ->where('status', 1);
        })->orderBy('id', 'DESC')->get();

        return $datatable->render('admin.flash-sale.index', compact('flashSale', 'products'));
    }

    public function update(Request $request) {
        $request->validate([
            'end_date' => ['required']
        ]);

        FlashSale::updateOrCreate(
            ['id' => 1],
            ['end_date' => $request->end_date]
        );

        toastr('Flash Sale Updated successfully');
        return redirect()->back();
    }

    public function addProduct (Request $request) {
        $request->validate([
            'product' => ['required', 'unique:flash_sale_items,product_id'],
            'show_at_home' => ['required'],
            'status' => ['required']
        ], [
            'product.unique' => "The product already in flash Sales"
        ]);

        $flashSale = FlashSale::first();

        $flashSaleItem = new FlashSaleItem();
        $flashSaleItem->product_id = $request->product;
        $flashSaleItem->flash_sale_id = $flashSale->id;
        $flashSaleItem->show_at_home = $request->show_at_home;
        $flashSaleItem->status = $request->status;
        $flashSaleItem->save();

        toastr('Flash Item Created succesfully!');
        return redirect()->back();
    }

    public function changeShowHomeStatus (Request $request) {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->show_at_home = $request->isChecked == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response(['status' => 'success', 'message' => 'Show At home status Updated succcessfully!']);
    }

    public function changeStatus (Request $request) {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->status = $request->isChecked == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response(['status' => 'success', 'message' => 'Status Updated succcessfully!']);
    }

    public function destroy (Request $request) {
        $flashSaleItem = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->delete();

        return response(['status' => 'success', 'message' => 'Flash Sale Item Deleted succcessfully!']);
    }

}
