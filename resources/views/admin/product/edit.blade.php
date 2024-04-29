@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Product</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Create Product</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.product.update', $product->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Image Preview</label>
                        <br />
                        <img width="200" src="{{asset($product->thumb_image)}}" class="" alt="banner">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" >
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{$product->name}}">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="inputState">Category</label>
                            <select id="inputState" class="form-control main-category" name="category">
                                <option value="">Select</option>
                                @foreach( $categories as $category)
                                    <option {{$product->category_id == $category->id? 'selected' : "" }} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Sub Category</label>
                            <select id="inputState" class="form-control sub-category" name="sub_category">
                                <option value="">Select</option>
                                @foreach( $subCategories as $subCategory)
                                    <option {{$product->sub_category_id == $subCategory->id? 'selected' : "" }} value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Child Category</label>
                            <select id="inputState" class="form-control child-category" name="child_category">
                                <option value="">Select</option>
                                @foreach( $childCategories as $childCategory)
                                    <option {{$product->child_category_id == $childCategory->id ? 'selected' : "" }} value="{{$childCategory->id}}">{{$childCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputState">Brands</label>
                        <select id="inputState" class="form-control" name="brand">
                            @foreach( $brands as $brand)
                                <option {{$product->brand_id == $brand->id ? 'selected' : "" }} value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" class="form-control" name="sku" value="{{$product->sku}}">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" value="{{$product->price}}">
                    </div>
                    <div class="form-group">
                        <label>Offer Price</label>
                        <input type="number" class="form-control" name="offer_price" value="{{$product->offer_price}}">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Offer Start Date</label>
                            <input type="text" name="offer_start_date" class="form-control datepicker" value="{{$product->offer_start_date}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Offer End Date</label>
                            <input type="text" name="offer_end_date" class="form-control datepicker" value="{{$product->offer_end_date}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Video link</label>
                        <input type="text" class="form-control" name="video_link" value="{{$product->video_link}}">
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="number" min=0 class="form-control" name="qty" value="{{$product->qty}}">
                    </div>
                    <div class="form-group">
                        <label>seo Description</label>
                        <textarea type="text" class="form-control" name="short_description">{{$product->short_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea type="text" class="form-contro summernote" name="long_description">{{$product->long_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputState">Product Type</label>
                        <select id="inputState" class="form-control" name="product_type">
                            <option  value="">Select...</option>
                            <option {{$product->product_type == 'new_arrival' ? 'selected' : "" }} value="new_arrival">New Arrival</option>
                            <option {{$product->product_type == 'featured_product' ? 'selected' : "" }} value="featured_product">Featured</option>
                            <option {{$product->product_type == 'top_product' ? 'selected' : "" }} value='top_product'>Top Product</option>
                            <option {{$product->product_type == 'best_product' ? 'selected' : "" }} value='best_product'>Best Product</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" class="form-control" name="seo_title" value="{{$product->seo_title}}">
                    </div>
                    <div class="form-group">
                        <label>SEO Description</label>
                        <textarea type="text" class="form-control" name="seo_description">{{$product->seo_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputState">Status</label>
                        <select id="inputState" class="form-control" name="status">
                          <option {{$product->status == 1 ? 'selected' : "" }}  value=1>Active</option>
                          <option {{$product->status == 0 ? 'selected' : "" }} value=0>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
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

        //get Sub categories
      $(document).ready( function() {
          $('body').on('change', '.main-category', function(e) {
              $('.child-category').html(`<option value="">Select</option>`)
              let id = $(this).val();
              $.ajax({
                  method: "GET",
                  url: "{{route('admin.product.get-sub-categories')}}",
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

        //get Sub categories
        $(document).ready( function() {
          $('body').on('change', '.sub-category', function(e) {
              let id = $(this).val();
              $.ajax({
                  method: "GET",
                  url: "{{route('admin.product.get-child-categories')}}",
                  data: {
                    id: id
                  },
                  success: function(data) {
                    $('.child-category').html(`<option value="">Select</option>`)
                    $.each(data, function(i, item) {
                      $('.child-category').append(`<option value=${item.id}>${item.name}</option>`)
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
