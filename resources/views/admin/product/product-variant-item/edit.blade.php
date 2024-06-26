@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Product Variant Items</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Edit Product Variant Items</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.product-variant-item.update', $variantItem->id)}}">
                  @csrf
                  @method("PUT")
                  <div class="form-group">
                    <label>Variant Name</label>
                    <input type="text" class="form-control" name="variant_name" readonly value="{{$variant->name}}">
                  </div>
                  <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" class="form-control" name="name" value="{{$variantItem->name}}">
                  </div>
                  <div class="form-group">
                    <label>Price  <code>(Enter 0 if item free)</code></label>
                    <input type="text" class="form-control" name="price" value="{{$variantItem->price}}">
                  </div>
                  <input type="hidden" name="variant_id" value="{{$variant->id}}">

                  <div class="form-group">
                    <label for="inputState">Default</label>
                    <select id="inputState" class="form-control" name="is_default">
                      <option value="">Select...</option>
                      <option {{$variantItem->is_default == 1 ? 'selected' : ''}} value=1>Yes</option>
                      <option {{$variantItem->is_default == 0 ?'selected' : ''}} value=0>No</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="inputState">Status</label>
                    <select id="inputState" class="form-control" name="status">
                      <option {{$variantItem->status == 1 ? 'selected' : ''}} value=1>Active</option>
                      <option  {{$variantItem->status == 0 ? 'selected' : ''}} value=0>Inactive</option>
                    </select>
                  </div>
                  <button class='btn btn-primary'>Update</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

