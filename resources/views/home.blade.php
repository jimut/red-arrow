@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>You are logged in!</p>
                    <a href="{{ route('donor.create') }}" class="btn btn-primary">Register as a Donor</a>
                    <a href="{{ route('hospital.create') }}" class="btn btn-primary">Register as a Hospital</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
