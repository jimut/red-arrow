@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <img src="{{ url('imagecache/avatar/' . $hospital->avatar) }}" alt="avatar" class="avatar-profile">
        </div>
        <div class="col-md-8">
            <h1>{{ $hospital->name }}</h1>
            <p>
                <strong>Regitration Number:</strong> {{ $hospital->reg_no }} <br>
                <strong>Contact Number:</strong> {{ $hospital->contact_no }} <br>
                <strong>Address:</strong> {{ $hospital->address }}
            </p>
            <a href="{{ route('hospital.edit', $hospital->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>

@endsection
