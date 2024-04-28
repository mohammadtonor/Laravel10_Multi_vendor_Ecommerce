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
            <h3><i class="far fa-user"></i>Shop profile</h3>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                <form action='{{route('admin.product-image-gallery.store')}}' method='POST' enctype='multipart/form-data'>
                    @csrf
                    <div class='form-group wsus__input'>
                        <label>Image <code>(Multiple image supported!)</code></label>
                        <input type='file' class='form-control' name='image[]' multiple/>
                        <input type='hidden' name='product_id' value=""/>
                    </div>
                    <button class='btn btn-primary'>Upload</button>
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
