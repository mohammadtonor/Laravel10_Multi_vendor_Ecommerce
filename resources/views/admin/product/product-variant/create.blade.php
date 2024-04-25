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
              <h4>Create Product Variant</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.category.store')}}">
                  @csrf
                  <div class="form-group">
                    <label>Icon</label>

                    <!-- Button tag -->
                    <div>
                      <button class="btn btn-primary" data-icon="" data-selected-class="btn-danger"
                      data-unselected-class="btn-info" role="iconpicker" name="icon"></button>
                    </div>

                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{old('title')}}">
                  </div>
                  <div class="form-group">
                    <label for="inputState">Status</label>
                    <select id="inputState" class="form-control" name="status">
                      <option value=1>Active</option>
                      <option value=0>Inactive</option>
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

