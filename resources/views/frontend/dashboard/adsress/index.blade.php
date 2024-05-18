@extends('frontend.dashboard.layouts.master')

@section('content')
<section id="wsus__dashboard">
    <div class="container-fluid">
      @include('frontend.dashboard.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content">
            <h3><i class="fal fa-gift-card"></i> address</h3>
            <div class="wsus__dashboard_add">
              <div class="row">
                <div class="col-xl-6">
                  @foreach ($userAddresses as $userAddresse)
                    <div class="wsus__dash_add_single">
                        <h4>Billing Address</h4>
                        <ul>
                            <li><span>name :</span> {{$userAddresse->name}}</li>
                            <li><span>Phone :</span> +{{$userAddresse->phone}}</li>
                            <li><span>email :</span> {{$userAddresse->email}}</li>
                            <li><span>country :</span> {{$userAddresse->country}}</li>
                            <li><span>state :</span> {{$userAddresse->state}}</li>
                            <li><span>city :</span> {{$userAddresse->city}}</li>
                            <li><span>zip code :</span> {{$userAddresse->zip}}</li>
                            <li><span>address :</span> {{$userAddresse->address}}</li>
                        </ul>
                        <div class="wsus__address_btn gap-2">
                            <a href="{{route('user.address.edit', $userAddresse->id)}}" class="edit"><i class="fal fa-edit"></i> edit</a>
                            <a href="{{route('user.address.destroy', $userAddresse->id)}}" class="del delete-item"><i class="fal fa-trash-alt"></i> delete</a>
                        </div>
                    </div>
                  @endforeach
                </div>
                <div class="col-12">
                  <a href="{{route('user.address.create')}}" class="add_address_btn common_btn"><i class="far fa-plus"></i>
                    add new address</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
