@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>You are logged in!</p>

                    @if (!$isUserRegistered)
                        <a href="{{ route('donor.create') }}" class="btn btn-primary">Register as a Donor</a>
                        <a href="{{ route('hospital.create') }}" class="btn btn-primary">Register as a Hospital</a>
                    @endif

                    @if ($isUserHospital)
                        <a href="{{ route('donor.find') }}" class="btn btn-primary">Search for a Donor</a>
                    @endif

                    @if ($isUserDonor)
                        <p>You have {{ $notificationCount }} notifications</p>
                        <a href="{{ route('donor.notification') }}" class="btn btn-primary">View Notifications</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
