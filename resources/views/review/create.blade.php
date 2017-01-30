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

                        <form class="form-horizontal" action="{{ route('appointment.review.store', $appointment) }}" method="POST">

                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('review') ? 'has-error' : '' }}">
                                <label for="review" class="col-md-4 control-label">Review</label>

                                <div class="col-md-6">
                                    <textarea id="review" class="form-control" name="review" value="{{ old('review') }}" rows="8"></textarea>

                                    @if ($errors->has('review'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('review') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
