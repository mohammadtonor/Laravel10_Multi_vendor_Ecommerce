@extends('vendor.layouts.master')

@section('title')
    {{$settings->site_name}} || Variant Item
@endsection

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
            <a class='btn btn-warning mb-4' href="{{route('vendor.products-variant.index', ['product' => $variant->product_id])}}">
                <i class="fa-regular fa-arrow-left-long"></i>
                 Back
            </a>
            <h3><i class="far fa-user"></i>Product Varinat: {{$variant->name}}</h3>
            <div class="create_button">
                <a href="{{route('vendor.products-variant-item.create', ['variantId' => $variant->id])}}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Item</a>
            </div>
          </div>
        </div>
      </div>


      <div class="row ">
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

<script>
    $('document').ready(function() {
        $('body').on('click' , '.change-status', function () {
            let isChecked = $(this).is(':checked');
            let id = $(this).data('id');

            $.ajax({
                url: "{{route('vendor.products-variant-item.change-status')}}",
                method: 'PUT',
                data: {
                  isChecked: isChecked,
                  id: id
                },
                success: function(data) {
                   toastr.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        })
    })
</script>
@endpush
