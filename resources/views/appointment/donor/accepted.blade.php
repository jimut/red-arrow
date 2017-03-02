@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="text-white">Accepted appointments</h1>
                <p class="text-white">You accepted these appointments and a patient is waiting for you.</p>
            </div>
        </div>

        <div class="divider-30"></div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group weird-shadow">
                    @foreach ($accepted as $appointment)
                        <li class="list-group-item flex-row">
                            <div class="flex">
                                <h4 class="list-group-item-heading">{{ $appointment->hospital->name }}</h4>
                                <p class="list-group-item-text">{{ $appointment->hospital->address }}</p>
                            </div>
                            <div class="btn-group flex-no-shrink">
                                <a href="https://www.google.co.in/maps?saddr={{ $appointment->donor->map_lat }},{{ $appointment->donor->map_lng }}&daddr={{ $appointment->hospital->map_lat }},{{ $appointment->hospital->map_lng }}" target="_blank" class="btn btn-primary">Show Directions</a>
                                <a href="{{ route('appointment.reject', $appointment) }}" class="btn btn-danger">Reject</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="backdrop-weird-color"></div>

@endsection
