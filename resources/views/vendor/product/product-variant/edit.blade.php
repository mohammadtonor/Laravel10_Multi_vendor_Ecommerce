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
            <a class='btn btn-warning mb-4' href="{{route('vendor.products-variant.index', ['product' => $varinat->product_id])}}">
                <i class="fa-regular fa-arrow-left-long"></i>
                 Back
            </a>
            <h3><i class="far fa-user"></i>Edit Variant</h3>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form method="POST" action="{{route('vendor.products-variant.update', $varinat->id)}}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group wsus__input">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" value="{{$varinat->name}}">
                  </div>
                    <div class="form-group wsus__input">
                        <input type="hidden" class="form-control" name="product" value="{{$varinat->product_id}}">
                    </div>
                  <div class="form-group wsus__input">
                      <label for="inputState">Status</label>
                      <select id="inputState" class="form-control" name="status">
                        <option {{$varinat->status == 1 ? 'selected' : ''}} value=1>Active</option>
                        <option {{$varinat->status == 0 ? 'selected' : ''}} value=0>Inactive</option>
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Create</button>
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
