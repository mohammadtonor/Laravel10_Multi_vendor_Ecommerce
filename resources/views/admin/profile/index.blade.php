@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Profile</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Hi, Ujang!</h2>
      <div class="row mt-sm-4 d-flex justify-content-center">
        <div class="col-3 col-md-3 col-lg-5">
            <div class="profile-widget">
              <div class="profile-widget-header">                     
                <img alt="image" src="{{asset('backend/assets/img/avatar/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
              </div>
            </div>
        </div>
      </div>
      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-7">
          <div class="card">
            <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data" action="{{route('admin.profile.update')}}">
            @csrf
              <div class="card-header">
                <h4>Edit Profile</h4>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="form-group col-12">
                      <label>Name</label>
                      <input type="file" name="image" class="form-control" >
                      <div class="invalid-feedback">
                        Please fill in the name
                      </div>
                    </div>
                  </div>
                  <div class="row">                               
                    <div class="form-group col-md-6 col-12">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" required="">
                      <div class="invalid-feedback">
                        Please fill in the name
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" required="">
                      <div class="invalid-feedback">
                        Please fill in the email
                      </div>
                    </div>
              </div>
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
       
    </div>
  </section>
@endsection