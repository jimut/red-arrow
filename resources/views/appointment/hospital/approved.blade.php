@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="text-white">Approved appointments</h1>
                <p class="text-white">These donors are approved by you.</p>
            </div>
        </div>

        <div class="divider-30"></div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group weird-shadow">
                    @foreach ($approved as $appointment)
                        <li class="list-group-item flex-row">
                            <div class="flex">
                                <h4 class="list-group-item-heading">{{ $appointment->donor->name }}</h4>
                                <p class="list-group-item-text">{{ $appointment->donor->address }}</p>
                            </div>
                            <div>
                                @if ($appointment->donor_review)
                                    <a href="{{ route('appointment.review.show', $appointment) }}" class="btn btn-primary">View Review</a>
                                @else
                                    <a href="{{ route('appointment.review.create', $appointment) }}" class="btn btn-primary">Write Review</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="backdrop-weird-color"></div>

@endsection
