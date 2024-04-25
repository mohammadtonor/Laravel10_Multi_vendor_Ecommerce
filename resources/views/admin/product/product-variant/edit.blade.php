@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Product Variant</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Edit Product Variant</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.product-variant.update', $productVariant->id)}}">
                  @csrf
                  @method("PUT")
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$productVariant->name}}">
                  </div>
                  <input type="hidden" name="product" value="{{$productVariant->product_id}}">
                  <div class="form-group">
                    <label for="inputState">Status</label>
                    <select id="inputState" class="form-control" name="status">
                      <option {{$productVariant-> status == 1 ? 'selected' : ''}} value=1>Active</option>
                      <option {{$productVariant-> status == 0 ? 'selected' : ''}} value=0>Inactive</option>
                    </select>
                  </div>
                  <button class='btn btn-primary'>Updata</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

