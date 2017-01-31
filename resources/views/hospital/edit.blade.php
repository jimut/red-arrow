@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register as a Hospital</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('hospital.update', $hospital->id) }}" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label">Avatar</label>

                            <div class="col-md-6 avatar-chooser">
                                <img src="{{ $hospital->avatar }}" alt="avatar" class="avatar-box">
                                <input id="avatar" type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Hospital Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $hospital->name }}"
                                required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('reg_no') ? 'has-error' : '' }}">
                            <label for="reg_no" class="col-md-4 control-label">Registration Number</label>

                            <div class="col-md-6">
                                <input id="reg_no" type="text" class="form-control" name="reg_no" value="{{ $hospital->reg_no }}" required>

                                @if ($errors->has('reg_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reg_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                            <label for="contact_no" class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input id="contact_no" type="text" class="form-control" name="contact_no" value="{{ $hospital->contact_no }}" required>

                                @if ($errors->has('contact_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="address-input-map"></div>
                            <input id="pac-input" type="text" class="map-control" placeholder="Search...">
                            <input id="map_lat" type="hidden" name="map_lat" value="{{ $hospital->map_lat }}">
                            <input id="map_lng" type="hidden" name="map_lng" value="{{ $hospital->map_lng }}">
                        </div>

                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $hospital->address }}" required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
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

@endsection
