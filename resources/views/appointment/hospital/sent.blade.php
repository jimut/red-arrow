@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Accepted appointments</h1>
                <p>You sent notifications to these people.</p>
            </div>
        </div>

        <div class="divider-30"></div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    @foreach ($sent as $appointment)
                        <li class="list-group-item flex-row">
                            <div class="flex">
                                <h4 class="list-group-item-heading">{{ $appointment->donor->name }}</h4>
                                <p class="list-group-item-text">{{ $appointment->donor->address }}</p>
                            </div>
                            <div>
                                <a href="https://www.google.co.in/maps?saddr={{ $appointment->donor->map_lat }},{{ $appointment->donor->map_lng }}&daddr={{ $appointment->hospital->map_lat }},{{ $appointment->hospital->map_lng }}" target="_blank" class="btn btn-primary">Show Directions</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
