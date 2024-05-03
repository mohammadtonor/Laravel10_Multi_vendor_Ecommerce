@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Shipping Rules</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Create  Shipping Rule</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.shipping-rules.update', $shippingRule->id)}}">
                  @csrf
                  @method('PUT')

                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$shippingRule->name}}">
                  </div>

                  <div class="form-group">
                    <label for="inputState">Type</label>
                    <select id="inputState" class="form-control shipping_type" name="type">
                      <option {{$shippingRule->type == 'flat_cost' ? 'selected' : ''}} value="flat_cost">Flat Cost</option>
                      <option {{$shippingRule->type == 'min_cost' ? 'selected' : ''}} value="min_cost  ">Minimum Order Amount</option>
                    </select>
                  </div>

                  <div class="form-group min_cost d-none">
                    <label>Minimum Cost</label>
                    <input type="number" class="form-control " name="min_cost" value="{{$shippingRule->min_cost}}">
                  </div>

                  <div class="form-group">
                    <label>Cost</label>
                    <input type="number" class="form-control" name="cost" value="{{$shippingRule->cost}}">
                  </div>

                  <div class="form-group">
                    <label for="inputState">Status</label>
                    <select id="inputState" class="form-control" name="status">
                      <option {{$shippingRule->status == 1? 'selected'  : ''}} value=1>Active</option>
                      <option {{$shippingRule->status == 0? 'selected'  : ''}} value=0>Inactive</option>
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

@push('scripts')
    <script>
        $(document).ready(function () {
            $('body').on('change', '.shipping_type', function () {
                let value = $(this).val();
            if(value === 'flat_cost'){
                $('.min_cost').addClass('d-none')
            }else {
                $('.min_cost').removeClass('d-none')
            }
            })
        })
    </script>
@endpush
