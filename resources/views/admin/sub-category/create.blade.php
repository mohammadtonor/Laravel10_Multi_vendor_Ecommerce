@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Sub Category</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Create Sub Categories</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.sub-category.store')}}">
                  @csrf
                  <div class="form-group">
                    <label for="inputState">Category</label>
                    <select id="inputState" class="form-control" name="category">
                      <option value="">Select a category</option>
                      @foreach ($categories as $category)
                      <option value={{$category->id}}>{{$category->name}}</option>
                      @endforeach
                    </select>
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

