@extends('layouts.app')

@section('content')
<div class="container weird-shadow">
    <div class="row flex-row">
        <div class="col-md-2 text-center left-column">
            <img src="{{ $hospital->avatar }}" alt="avatar" class="row avatar-full-width">
            <div class="h4">{{ $hospital->name }}</div>
            <div class="divider-50"></div>
            <div class="h4">Hospital ID</div>
            <div class="h2">IND{{ $hospital->id }}</div>
            <div class="divider-50"></div>
            <div class="h4">Donations Taken</div>
            <div class="h2">{{ $count['completed'] }}</div>
        </div>
        <div class="col-md-10 right-column">
            <div class="row">
                <div class="col-md-4">
                    <h1>{{ $hospital->name }}</h1>
                    <p>
                        <strong>Regitration Number:</strong> {{ $hospital->reg_no }} <br>
                        <strong>Contact Number:</strong> {{ $hospital->contact_no }} <br>
                        <strong>Address:</strong> {{ $hospital->address }}
                    </p>
                    <a href="{{ route('hospital.edit', $hospital->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('donor.find') }}" class="btn btn-primary">Search for a Donor</a>
                </div>
            </div>

            <div class="row">
                <div style="padding-top: 100px"></div>
            </div>

            <div class="row">
                <div class="col-md-3">
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
    </div>
</div>

<div class="backdrop-weird-color"></div>
@endsection
