@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Donation Review</div>

                    <div class="panel-body">
                        <div class="row space-bottom">
                            <div class="col-md-4 text-right"><strong>Donor Name</strong></div>
                            <div class="col-md-6">{{ $appointment->donor->name }}</div>
                        </div>

                        <div class="row space-bottom">
                            <div class="col-md-4 text-right"><strong>Hospital Name</strong></div>
                            <div class="col-md-6">{{ $appointment->hospital->name }}</div>
                        </div>

                        <div class="row space-bottom">
                            <div class="col-md-4 text-right"><strong>Review</strong></div>
                            <div class="col-md-6">{{ $appointment->donor_review }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
