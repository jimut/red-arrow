@extends('layouts.app')

@section('content')

<div class="container" ng-controller="DirectionController">
    <div class="row">
        <div class="md-col-8 md-col-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Directions</div>

                <div class="panel-body">
                    <div id="direction-map" style="height: 700px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
