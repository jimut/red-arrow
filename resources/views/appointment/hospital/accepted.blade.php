@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Accepted Appointments</div>

                    <div class="panel-body">
                        <p>These people have accepted the appointment and are possibly coming.</p>
                    </div>

                    <ul class="list-group">
                        @foreach ($accepted as $appointment)
                            <li class="list-group-item">
                                <div class="row">
                                    <p class="col-md-6" style="font-size: 18px;">{{ $appointment->donor->name }}</p>
                                    <div class="col-md-6">
                                        <a href="{{ route('appointment.approve', $appointment) }}" class="btn btn-primary pull-right">Approve</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
