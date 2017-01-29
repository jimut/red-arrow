@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Approved Appointments</div>

                    <div class="panel-body">
                        <p>These donors are approved by you.</p>
                    </div>

                    <ul class="list-group">
                        @foreach ($approved as $appointment)
                            <li class="list-group-item">
                                <div class="row">
                                    <p class="col-md-6" style="font-size: 18px;">{{ $appointment->donor->name }}</p>
                                    <div class="col-md-6">
                                        <a href="{{ route('appointment.review.create', $appointment) }}" class="btn btn-primary pull-right space-left">Write Review</a>
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
