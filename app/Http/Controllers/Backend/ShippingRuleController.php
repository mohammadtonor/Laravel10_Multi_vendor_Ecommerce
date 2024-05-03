<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ShippingRuleRepo;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected ShippingRuleRepo $shippingRule,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $datatable)
    {
        return $datatable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> ['required', 'max:200'],
            'type'=> ['required', 'max:200'],
            'cost'=> ['required', 'integer'],
            'min_cost'=> ['nullable', 'integer'],
            'status'=> ['required',],
        ]);

        $response = $this->shippingRule->storeShippingRule(
            $request->name,
            $request->type,
            $request->cost,
            $request->min_cost,
            $request->status,
        );

        if ($response['status'] == 'success') {
            toastr('Created Succussffuly');
            return redirect()->route('admin.shipping-rules.index');
        } else {
            toastr('Failed  Creating');
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
        $shippingRule = ShippingRule::findOrFail($id);
        return view('admin.shipping-rule.edit', compact('shippingRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=> ['required', 'max:200'],
            'type'=> ['required', 'max:200'],
            'cost'=> ['required', 'integer'],
            'min_cost'=> ['nullable', 'integer'],
            'status'=> ['required',],
        ]);

        $response = $this->shippingRule->updateShippingRule(
            $id,
            $request->name,
            $request->type,
            $request->cost,
            $request->min_cost,
            $request->status,
        );

        if ($response['status'] == 'success') {
            toastr('Updatimg Succussffuly');
            return redirect()->route('admin.shipping-rules.index');
        } else {
            toastr('Failed while Updating');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->shippingRule->deleteShippingRule($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Deleted Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Deleting!']) ;
    }

    public function changeStatus (Request $request)
    {
        $response = $this->shippingRule->changeShippingRuleStatus($request->id, $request->isChecked);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Status Updated Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Updating!']) ;
    }
}
