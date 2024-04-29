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
            <a class='btn btn-warning mb-4' href="{{route('vendor.products.index')}}">
                <i class="fa-regular fa-arrow-left-long"></i>
                 Back
            </a>
            <h3><i class="far fa-user"></i>Product: {{$product->name}}</h3>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action="{{route('vendor.product-image-gallery.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group wsus__input">
                        <label for="">Image <code>(Multiple image supported!)</code></label>
                        <input type="file" name="image[]" class="form-control" multiple>
                        <input type="hidden" name="product" value="{{$product->id}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row mt-5">
            <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                <div class="dashboard_content mt-2 mt-md-0">
                    <div class="wsus__dashboard_profile">
                        <div class="wsus__dash_pro_area">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
             </div>
            </div>
          </div>
      </div>
  </section>

@endsection
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@endpush
