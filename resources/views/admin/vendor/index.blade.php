@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>View Profile</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Update vendor Profile</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('admin.vendor-profile.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Preview</label>
                        <br />
                        <img src="{{asset($profile->banner)}}" width="200" alt="banner" >
                    </div>
                    <div class="form-group">
                        <label>Banner</label>
                        <input type="file" class="form-control" name="banner" >
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{$profile->phone}}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{$profile->email}}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{$profile->address}}">
                    </div>
                    <div class="form-group">
                      <label >Description</label>
                        <textarea class="summernote" name="description" maxlength="3">{{$profile->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" class="form-control" name="fb_link" value="{{$profile->fa_link}}">
                    </div>
                    <div class="form-group">
                        <label>Whatt's up</label>
                        <input type="text" class="form-control" name="wa_link" value="{{$profile->wa_link}}">
                    </div>
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" class="form-control" name="insta_link" value="{{$profile->insta_link}}">
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
