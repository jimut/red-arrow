@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Donation History</div>

                    <div class="panel-body">
                        <p>These are your donation history.</p>
                    </div>

                    <ul class="list-group">
                        @foreach ($completed as $appointment)
                            <li class="list-group-item">
                                <div class="row">
                                    <p class="col-md-6" style="font-size: 18px;">{{ $appointment->hospital->name }}</p>
                                    <div class="col-md-6">
                                        @if ($appointment->donor_review)
                                            <a href="{{ route('appointment.review.show', $appointment) }}" class="btn btn-primary pull-right space-left">View Review</a>
                                        @endif
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
