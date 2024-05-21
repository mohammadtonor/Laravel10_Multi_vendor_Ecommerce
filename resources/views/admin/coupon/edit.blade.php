@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Coupons</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Create  Coupon</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.coupons.update', $coupon->id)}}">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$coupon->name}}">
                  </div>

                  <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" name="code" value="{{$coupon->code}}">
                  </div>

                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" class="form-control" name="quantity" value="{{$coupon->quantity}}">
                  </div>

                  <div class="form-group">
                    <label>Max Use Per Person</label>
                    <input type="text" class="form-control" name="max_use" value="{{$coupon->max_use}}">
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                        <label>start Date</label>
                        <input type="text" class="form-control datepicker" name="start_date" value="{{$coupon->start_date}}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>End Date</label>
                        <input type="text" class="form-control datepicker" name="end_date" value="{{$coupon->end_date}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="inputState">Discount Type</label>
                        <select id="inputState" class="form-control sub-category" name="discount_type">
                            <option {{$coupon->discount_type == 'percent' ? 'selected' : ''}} value="percent">Percentage (%)</option>
                            <option {{$coupon->discount_type == 'amount' ? 'selected' : ''}} value="amount">Amount ({{$settings->currency_icon}})</option>
                        </select>
                    </div>

                    <div class="form-group col-md-8">
                        <label>Discount Value</label>
                        <input type="text" class="form-control" name="discount_value" value="{{$coupon->discount}}">
                    </div>
                </div>

                  <div class="form-group">
                    <label for="inputState">Status</label>
                    <select id="inputState" class="form-control" name="status">
                      <option {{$coupon->status == 1 ? 'selected' : ''}} value=1>Active</option>
                      <option {{$coupon->status == 0 ? 'selected' : ''}} value=0>Inactive</option>
                    </select>
                  </div>
                  <button class='btn btn-primary'>Create</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

