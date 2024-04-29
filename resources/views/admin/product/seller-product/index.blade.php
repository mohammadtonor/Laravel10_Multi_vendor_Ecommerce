@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Seller Product</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>All Product</h4>
              <div class="card-header-action">
                <a href="{{route('admin.product.create')}}" class="btn btn-primary">
                  <i class="fas fa-plus"></i>
                  Create New
                </a>
              </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
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
                    url: "{{route('admin.product.change-status')}}",
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

        //Change Approve
        $('document').ready(function () {
            $('body').on('change', '.is_approve', function () {
                is_approved = $(this).val()
                let id = $(this).data('id');

                $.ajax({
                    url: "{{route('admin.change-seller-product-approving')}}",
                    method: 'PUT',
                    data: {
                      is_approved: is_approved,
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
