@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-white">Edit information</h1>

            <div class="divider-10"></div>

            <div class="panel panel-default weird-shadow">
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('donor.update', $donor->id) }}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label">Avatar</label>

                            <div class="col-md-6 avatar-chooser">
                                <img src="{{ $donor->avatar }}" alt="avatar" class="avatar-box">
                                <input id="avatar" type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Donor Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $donor->name }}"
                                required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                            <label for="dob" class="col-md-4 control-label">Date of Birth</label>

                            <div class="col-md-6">
                                <input type="date" class="form-control" name="dob" id="dob" value="{{ $donor->dob }}" required>

                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="address-input-map"></div>
                            <input id="pac-input" type="text" class="map-control" placeholder="Search...">
                            <input id="map_lat" type="hidden" name="map_lat" value="{{ $donor->map_lat }}">
                            <input id="map_lng" type="hidden" name="map_lng" value="{{ $donor->map_lng }}">
                        </div>

                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $donor->address }}" required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                            <label for="contact_no" class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input id="contact_no" type="number" class="form-control" name="contact_no" value="{{ $donor->contact_no }}" required>

                                @if ($errors->has('contact_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('blood_type') ? 'has-error' : '' }}">
                            <label for="blood-type" class="col-md-4 control-label">Blood Type</label>

                            <div class="col-md-6">
                                <select id="blood_type" class="form-control" name="blood_type" required>
                                    <option {{ $donor->blood_type == 'A+'  ? 'selected':'' }}>A+</option>
                                    <option {{ $donor->blood_type == 'A-'  ? 'selected':'' }}>A-</option>
                                    <option {{ $donor->blood_type == 'B+'  ? 'selected':'' }}>B+</option>
                                    <option {{ $donor->blood_type == 'B-'  ? 'selected':'' }}>B-</option>
                                    <option {{ $donor->blood_type == 'AB+' ? 'selected':'' }}>AB+</option>
                                    <option {{ $donor->blood_type == 'AB-' ? 'selected':'' }}>AB-</option>
                                    <option {{ $donor->blood_type == 'O+'  ? 'selected':'' }}>O+</option>
                                    <option {{ $donor->blood_type == 'O-'  ? 'selected':'' }}>O-</option>
                                </select>

                                @if ($errors->has('blood_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('blood_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('health_issues') ? 'has-error' : '' }}">
                            <label for="health_issues" class="col-md-4 control-label">Health Issues</label>

                            <div class="col-md-6">
                                <textarea id="health_issues" class="form-control" name="health_issues">{{ $donor->health_issues }}</textarea>

                                @if ($errors->has('health_issues'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('health_issues') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="backdrop-weird-color"></div>
@endsection
