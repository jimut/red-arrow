@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-3">
            <img src="{{ $donor->avatar }}" alt="avatar" class="avatar-profile">
        </div>
        <div class="col-md-4">
            <h1>Hi, {{ $donor->name }}</h1>
            <p>
                <strong>Date of Birth:</strong> {{ $donor->dob }} <br>
                <strong>Address:</strong> {{ $donor->address }} <br>
                <strong>Blood Type:</strong> {{ $donor->blood_type }} <br>
                <strong>Contact Number:</strong> {{ $donor->contact_no }} <br>
            </p>
            <a href="{{ route('donor.edit', $donor->id) }}" class="btn btn-default">Edit</a>
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
                    <div class="count-desc">Recieved<br>appointments</div>
                    <a href="{{ route('appointment.received') }}" class="btn btn-primary">View</a>
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
                    <div class="count-desc">Donation<br>history</div>
                    <a href="{{ route('user.donation') }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
