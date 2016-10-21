@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <h1>{{ $hospital->name }}</h1>
            <p>
                Regitration Number: {{ $hospital->reg_no }} <br>
                Contact Number: {{ $hospital->contact_no }} <br>
                Address: {{ $hospital->address }} 
            </p>
        </div>
    </div>
</div>

@endsection
