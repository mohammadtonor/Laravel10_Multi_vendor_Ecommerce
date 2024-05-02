<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.general-setting.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="{{$generalSetting->site_name}}">
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="layout" class="form-control">
                        <option {{$generalSetting->layout == 'LTR'? 'selected' : '' }} value="LTR">LTR</option>
                        <option {{$generalSetting->layout == 'RTL'? 'selected' : '' }} value="RTL">RTL</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="text" class="form-control" name="contact_email" value="{{$generalSetting->contact_email}}">
                </div>
                <div class="form-group">
                    <label>Currency Name</label>
                    <select class="form-control select2" name="currency_name">
                        <option value="">Select...</option>
                        @foreach (config('setting.currncy_list') as $currency)
                            <option {{$generalSetting->currency_name == $currency? 'selected': ''}} value="{{$currency}}">{{$currency}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Currency Icon</label>
                    <input type="text" class="form-control" name="currency_icon" value="{{$generalSetting->currency_icon}}">
                </div>
                <div class="form-group">
                    <label>Time Zone</label>
                    <select name="time_zone" class="form-control select2">
                        <option value="">Select...</option>
                        @foreach (config('setting.time_zone') as $key => $timeZone)
                            <option {{$generalSetting->time_zone == $key? 'selected': ''}} value="{{$key}}">{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>
