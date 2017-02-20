@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-3">
            <h1>Welcome!</h1>
            <p>You can either register as a donor or as a hospital. This is a one time process.</p>

            <a href="{{ route('donor.create') }}" class="btn btn-primary">Register as a Donor</a>
            <a href="{{ route('hospital.create') }}" class="btn btn-primary">Register as a Hospital</a>
        </div>
    </div>
</div>
@endsection
