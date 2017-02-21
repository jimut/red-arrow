@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Donation history</h1>
                <p>These are your donation history.</p>
            </div>
        </div>

        <div class="divider-30"></div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    @foreach ($completed as $appointment)
                        <li class="list-group-item flex-row">
                            <div class="flex">
                                <h4 class="list-group-item-heading">{{ $appointment->hospital->name }}</h4>
                                <p class="list-group-item-text">{{ $appointment->hospital->address }}</p>
                            </div>
                            @if ($appointment->donor_review)
                                <div>
                                    <a href="{{ route('appointment.review.show', $appointment) }}" class="btn btn-primary pull-right space-left">View Review</a>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
