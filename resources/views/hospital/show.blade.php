@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <h1>{{ $hospital->name }}</h1>
            <p>
                <strong>Regitration Number:</strong> {{ $hospital->reg_no }} <br>
                <strong>Contact Number:</strong> {{ $hospital->contact_no }} <br>
                <strong>Address:</strong> {{ $hospital->address }} 
            </p>
        </div>
    </div>
</div>

@endsection
