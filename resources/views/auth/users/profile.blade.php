@extends('layouts.app')

@section('title', 'Profile')

@section('orientation', 'hk-vertical-nav')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="mt-0 mb-3 header-title">Profile Details</h4>

            <form method="POST" action="{{ route('account') }}" role="form">
                @csrf
                 
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $user->name }}" required=""  placeholder="Enter name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $user->email }}" required=""  placeholder="Enter email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="roles">Roles</label>
                    @foreach ($user->roles as $role)
                    <div class="checkbox">
                        <input name="roles[]" id="checkbox{{ $role->id }}" type="checkbox" value="{{ $role->id }}" checked readonly="">
                        <label for="checkbox{{ $role->id }}">
                            {{ ucfirst($role->name) }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password">
                    <small id="passwordHelp" class="form-text text-muted">Leave it blank if you are not changing password</small>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                 
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Enter Password Confirmation">
                    <small id="passwordHelp" class="form-text text-muted">Leave it blank if you are not changing password</small>
                    @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->


@endsection