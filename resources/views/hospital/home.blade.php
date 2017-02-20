@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-3">
            <img src="{{ $hospital->avatar }}" alt="avatar" class="avatar-profile">
        </div>
        <div class="col-md-4">
            <h1>{{ $hospital->name }}</h1>
            <p>
                <strong>Regitration Number:</strong> {{ $hospital->reg_no }} <br>
                <strong>Contact Number:</strong> {{ $hospital->contact_no }} <br>
                <strong>Address:</strong> {{ $hospital->address }}
            </p>
            <a href="{{ route('hospital.edit', $hospital->id) }}" class="btn btn-default">Edit</a>
            <a href="{{ route('donor.find') }}" class="btn btn-primary">Search for a Donor</a>
        </div>
    </div>

    <div class="row">
        <div style="padding-top: 100px"></div>
    </div>

    <div class="row">
        <div class="col-md-3 col-md-offset-2">
            <div class="flex-row flex-align-start-end">
                <div class="count">{{ $count['virgin'] }}</div>
                <div>
                    <div class="count-desc">Sent<br>appointments</div>
                    <a href="{{ route('appointment.sent') }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="flex-row flex-align-start-end">
                <div class="count">{{ $count['accepted'] }}</div>
                <div>
                    <div class="count-desc">Accepted<br>appointments</div>
                    <a href="{{ route('appointment.accepted') }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="flex-row flex-align-start-end">
                <div class="count">{{ $count['completed'] }}</div>
                <div>
                    <div class="count-desc">Approved<br>appointments</div>
                    <a href="{{ route('appointment.approved') }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
