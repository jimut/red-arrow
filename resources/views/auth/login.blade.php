@extends('layouts.app')

@section('content')
<div class="flex-screen-center">
    <div class="card-sm">
        <h1>Login</h1>

        <div class="divider-10"></div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <form role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">E-Mail Address</label>

                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label">Password</label>

                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" disabled>
                    Login
                </button>

                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                    Forgot Your Password?
                </a>
            </div>
        </form>

        <hr>

        <a href="{{ url('auth/facebook') }}" id="facebook-login-link" class="btn btn-primary btn-facebook" disabled>
            <i class="fa fa-facebook-official"></i>Continue With Facebook
        </a>

        <div class="divider-15"></div>

        <a href="{{ url('auth/google') }}" id="google-login-link" class="btn btn-primary btn-google" disabled>
            <i class="fa fa-google"></i>Continue With Google
        </a>
    </div>
</div>

<div class="backdrop"></div>
@endsection
