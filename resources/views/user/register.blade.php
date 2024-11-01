<!-- resources/views/user/register.blade.php -->

@extends('layouts.user-app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Daftar') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
