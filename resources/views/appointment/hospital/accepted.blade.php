@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="text-white">Accepted appointments</h1>
                <p class="text-white">These people have accepted the appointment and are possibly coming.</p>
            </div>
        </div>

        <div class="divider-30"></div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group weird-shadow">
                    @foreach ($accepted as $appointment)
                        <li class="list-group-item flex-row">
                            <div class="flex">
                                <h4 class="list-group-item-heading">{{ $appointment->donor->name }}</h4>
                                <p class="list-group-item-text">{{ $appointment->donor->address }}</p>
                            </div>
                            <div>
                                <a href="{{ route('appointment.approve', $appointment) }}" class="btn btn-primary">Approve</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="backdrop-weird-color"></div>

@endsection
