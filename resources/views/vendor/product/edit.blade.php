@extends('vendor.layouts.master')

@section('content')
  <!--=============================
    DASHBOARD START
  ==============================-->
  <section id="wsus__dashboard">
    <div class="container-fluid">
    @include('vendor.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content mt-2 mt-md-0">
            <h3><i class="far fa-user"></i>Shop Product</h3>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form method="POST" action="{{route('vendor.products.update', $vendorProduct->id)}}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group wsus__input">
                    <label>Preview</label>
                    <br />
                    <img src="{{asset($vendorProduct->thumb_image)}}" width="300" height="200" style="object-fit: cover;" alt="thumb">
                </div>
                  <div class="form-group wsus__input">
                      <label>Image</label>
                      <input type="file" class="form-control" name="image" >
                  </div>
                  <div class="form-group wsus__input">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" value="{{$vendorProduct->name}}">
                  </div>
                  <div class="row">
                      <div class="form-group wsus__input col-md-4">
                          <label for="inputState">Category</label>
                          <select id="inputState" class="form-control main-category" name="category">
                            <option value="">Select</option>
                            @foreach( $categories as $category)
                                <option {{$vendorProduct->category_id == $category->id? 'selected' : "" }} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group wsus__input col-md-4">
                          <label for="inputState">Sub Category</label>
                          <select id="inputState" class="form-control sub-category" name="sub_category">
                            <option value="">Select</option>
                            @foreach( $subCategories as $subCategory)
                                <option {{$vendorProduct->sub_category_id == $subCategory->id? 'selected' : "" }} value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group wsus__input col-md-4">
                          <label for="inputState">Child Category</label>
                          <select id="inputState" class="form-control child-category" name="child_category">
                            <option value="">Select</option>
                            @foreach( $childCategories as $childCategory)
                                <option {{$vendorProduct->child_category_id == $childCategory->id ? 'selected' : "" }} value="{{$childCategory->id}}">{{$childCategory->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="form-group wsus__input">
                      <label for="inputState">Brands</label>
                      <select id="inputState" class="form-control" name="brand">
                          @foreach( $brands as $brand)
                              <option {{$vendorProduct->brand_id == $brand->id ? 'selected' : "" }} value="{{$brand->id}}">{{$brand->name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group wsus__input">
                      <label>SKU</label>
                      <input type="text" class="form-control" name="sku" value="{{$vendorProduct->sku}}">
                  </div>
                  <div class="form-group wsus__input">
                      <label>Price</label>
                      <input type="number" class="form-control" name="price" value="{{$vendorProduct->price}}">
                  </div>
                  <div class="form-group wsus__input">
                      <label>Offer Price</label>
                      <input type="number" class="form-control" name="offer_price" value="{{$vendorProduct->offer_price}}">
                  </div>
                  <div class="row">
                      <div class="form-group wsus__input col-md-6">
                          <label>Offer Start Date</label>
                          <input type="text" name="offer_start_date" class="form-control datepicker" value="{{$vendorProduct->offer_start_date}}">
                      </div>
                      <div class="form-group wsus__input col-md-6">
                          <label>Offer End Date</label>
                          <input type="text" name="offer_end_date" class="form-control datepicker" value="{{$vendorProduct->offer_end_date}}">
                      </div>
                  </div>
                  <div class="form-group wsus__input">
                      <label>Video link</label>
                      <input type="text" class="form-control" name="video_link" value="{{$vendorProduct->video_link}}">
                  </div>
                  <div class="form-group wsus__input">
                      <label>Stock Quantity</label>
                      <input type="number" min=0 class="form-control" name="qty" value="{{$vendorProduct->qty}}">
                  </div>
                  <div class="form-group wsus__input">
                      <label>seo Description</label>
                      <textarea type="text" class="form-control" name="short_description">{{$vendorProduct->short_description}}</textarea>
                  </div>
                  <div class="form-group wsus__input">
                      <label>Long Description</label>
                      <textarea type="text" class="form-contro summernote mb-4" name="long_description">{{$vendorProduct->long_description}}</textarea>
                  </div>
                  <div class="form-group wsus__input col-md-12 mt-6">
                      <label for="inputState">Product Type</label>
                      <select id="inputState" class="form-control" name="product_type">
                          <option value="">Select...</option>
                          <option {{$vendorProduct->product_type == 'new_arrival' ? 'selected' : "" }} value="new_arrival">New Arrival</option>
                          <option {{$vendorProduct->product_type == 'featured_product' ? 'selected' : "" }} value="featured_product">Featured</option>
                          <option {{$vendorProduct->product_type == 'top_product' ? 'selected' : "" }} value='top_product'>Top Product</option>
                          <option {{$vendorProduct->product_type == 'best_product' ? 'selected' : "" }} value='best_product'>Best Product</option>
                      </select>
                  </div>

                  <div class="form-group wsus__input">
                      <label>SEO Title</label>
                      <input type="text" class="form-control" name="seo_title" value="{{$vendorProduct->seo_title}}">
                  </div>
                  <div class="form-group wsus__input">
                      <label>SEO Description</label>
                      <textarea type="text" class="form-control" name="seo_description">{{$vendorProduct->seo_description}}</textarea>
                  </div>
                  <div class="form-group wsus__input">
                      <label for="inputState">Status</label>
                      <select id="inputState" class="form-control" name="status">
                        <option {{$vendorProduct->status == 1 ? 'selected' : "" }} value=1>Active</option>
                        <option {{$vendorProduct->status == 0 ? 'selected' : "" }} value=0>Inactive</option>
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Uodate</button>
              </form>
              </div>
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
          $('body').on('change', '.main-category', function(e) {
              let id = $(this).val();
              $.ajax({
                  method: "GET",
                  url: "{{route('vendor.products.get-sub-categories')}}",
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
                  url: "{{route('vendor.products.get-child-categories')}}",
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
  </script>
@endpush
