<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CouponRepo;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private CouponRepo $couponRepo;
    public function __construct(CouponRepo $couponRepo)
    {
        $this->couponRepo = $couponRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $datatable)
    {
        return $datatable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'quantity' => ['required'],
            'max_use' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'discount_type' => ['required'],
            'discount_value' => ['required'],
            'status' => ['required'],
        ]);

        $response = $this->couponRepo->storeCoupon(
            $request->name,
            $request->code,
            $request->quantity,
            $request->max_use,
            $request->start_date,
            $request->end_date,
            $request->discount_type,
            $request->discount_value,
            $request->status,
        );

        if($response['status'] == 'success') {
            toastr('Coupon Updated successfully');
            return redirect()->route('admin.coupons.index');
        } else {
            toastr('Error Updating Coupon');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'quantity' => ['required'],
            'max_use' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'discount_type' => ['required'],
            'discount_value' => ['required'],
            'status' => ['required'],
        ]);

        $response = $this->couponRepo->updateCoupon(
            $id,
            $request->name,
            $request->code,
            $request->quantity,
            $request->max_use,
            $request->start_date,
            $request->end_date,
            $request->discount_type,
            $request->discount_value,
            $request->status,
        );

        if($response['status'] == 'success') {
            toastr('Coupon created successfully');
            return redirect()->route('admin.coupons.index');
        } else {
            toastr('Error creating Coupon');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->couponRepo->deleteCoupon($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Deleted Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Deleting!']) ;
    }

    public function changeStatus (Request $request)
    {
        $response = $this->couponRepo->changeCouponStatus($request->id, $request->isChecked);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Status Updated Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Updating!']) ;
    }
}
