@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <img src="{{ url('imagecache/avatar/' . $donor->avatar) }}" alt="avatar" class="avatar-profile">
        </div>
        <div class="col-md-8">
            <h1>{{ $donor->name }}</h1>
            <p>
                <strong>Date of Birth:</strong> {{ $donor->dob }} <br>
                <strong>Address:</strong> {{ $donor->address }} <br>
                <strong>Blood Type:</strong> {{ $donor->blood_type }} <br>
                <strong>Contact Number:</strong> {{ $donor->contact_no }} <br>
            </p>
            <a href="{{ route('donor.edit', $donor->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>

@endsection
