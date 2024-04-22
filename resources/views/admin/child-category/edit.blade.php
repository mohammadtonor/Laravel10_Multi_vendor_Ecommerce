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
              <h4>Edit Sub Categories</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.child-category.update' , $childCategory->id)}}">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="inputState">Category</label>
                    <select id="inputState" class="form-control main-category" name="category">
                      <option value="">Select a category</option>
                      @foreach ($categories as $category)
                       <option {{$childCategory->category_id == $category->id ? 'selected' : ''}} value={{$category->id}}>{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputState">SubCategory</label>
                    <select id="inputState" class="form-control sub-category" name="sub_category">
                      <option value="">Select a category</option>
                      @foreach ($subCategories as $subCategory)
                      <option {{$childCategory->sub_category_id == $subCategory->id ? 'selected' : ''}} value={{$subCategory->id}}>{{$subCategory->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$childCategory->name}}">
                  </div>
                  <div class="form-group">
                    <label for="inputState">Status</label>
                    <select id="inputState" class="form-control" name="status" >
                      <option {{$childCategory->status == 1 ? 'selected' : ''}} value=1>Active</option>
                      <option {{$childCategory->status == 0 ? 'selected' : ''}} value=0>Inactive</option>
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

@push('scripts')
  <script>
    $(document).ready( function() {
        $('body').on('change', '.main-category', function (e) {
            let id = $(this).val();
            $.ajax({
                method: 'GET',
                url: "{{route('admin.child-category.get-sub-category')}}",
                data: {
                  id: id
                },
                success: function(data) {
                    $('.sub-category').html(`<option value="">Select Subcategory</option>`)
                    $.each(data, function(i, item) {
                      $('.sub-category').append(`<option value=${item.id}>${item.name}</option>`)
                    })
                  },
                error: function(xhr, status, error) {
                  console.log(error);
                } 
            })
        })
    })
  </script>
@endpush

