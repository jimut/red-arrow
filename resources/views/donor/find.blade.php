@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-group">
                    <label for="blood_type">Blood Type</label>
                    <select id="blood_type" class="form-control">
                        <option>A+</option>
                        <option>A-</option>
                        <option>B+</option>
                        <option>B-</option>
                        <option>AB+</option>
                        <option>AB-</option>
                        <option>O+</option>
                        <option>O-</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="search_radius">Radius</label>
                    <select id="search_radius" class="form-control">
                        @for ($i = 5; $i <= 200; $i += 5)
                            <option value="{{ $i }}">{{ $i }} km</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div id="find-map"></div>
@endsection
