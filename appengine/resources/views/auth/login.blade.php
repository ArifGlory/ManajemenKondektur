@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="blankpage-form-field">
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <span class="page-logo-text mr-1"><strong>Manajemen Kondektur</strong> </span>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input type="text" name="email" id="email" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan email anda.." value="{{ old('username') }}" required autocomplete="username" autofocus>
                    <span class="help-block">
                            Email anda yang digunakan untuk login apps
                        </span>
                    @error('username')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                    <span class="help-block">
                            Isikan password anda..
                        </span>
                </div>
                <div class="form-group text-left">
                    @if (isset($_SESSION["error_login"]))
                        <div class="alert alert-danger text-center msg" id="error">
                            <strong>{{ $_SESSION["error_login"] }}</strong>
                        </div>
                    @endif
                    {{--<strong>{{ $_SESSION["ngehe"] }}</strong>--}}
                </div>
                <button type="submit" class="btn btn-primary btn-round float-right"><span class="fal fa-sign-in"></span> Secure Login</button>
            </form>
        </div>
    </div>
    {{--<div class="login-footer p-2">
        <div class="row">
            <div class="col col-sm-12 text-center">
                <i><strong>System Message:</strong> You were logged out from 198.164.246.1 on Saturday, March, 2017 at 10.56AM</i>
            </div>
        </div>
    </div>--}}
@endsection
