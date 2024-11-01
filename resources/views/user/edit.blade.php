<!-- resources/views/user/edit.blade.php -->

@extends('layouts.user-app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User Data') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="no">{{ __('No') }}</label>
                                <input type="text" name="no" id="no" class="form-control" value="{{ old('no', $user->no) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
