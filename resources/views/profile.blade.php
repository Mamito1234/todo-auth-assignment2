@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2 class="mb-4">User Profile</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    {{-- <a href="{{ route('todo.index') }}" style="display:inline-block; margin-bottom:20px;">&larr; Back to To-Do List</a> --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('home') }}" class="btn btn-secondary">&larr; Back to Dashboard</a>
        <a href="{{ route('todo.index') }}" class="btn btn-outline-primary">Back to To-Do List</a>
    </div>

    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
        @csrf

        @if (auth()->user()->two_factor_secret)
            @method('DELETE')
            <button type="submit" class="btn btn-warning mb-3">
                Disable Two-Factor Authentication
            </button>
        @else
            <button type="submit" class="btn btn-success mb-3">
                Enable Two-Factor Authentication
            </button>
        @endif
    </form>

    @if (session('status') == 'two-factor-authentication-enabled')
    <div class="alert alert-success">
        Two-Factor Authentication Enabled.
    </div>
@endif

@if (auth()->user()->two_factor_secret)
    <h5>Scan this QR Code with your authenticator app:</h5>
    {!! auth()->user()->twoFactorQrCodeSvg() !!}

    <h5>Recovery Codes:</h5>
    <ul>
        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
            <li>{{ $code }}</li>
        @endforeach
    </ul>
@endif
<form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
    @csrf
    <button type="submit" class="btn btn-warning">
        Regenerate Recovery Codes
    </button>
</form>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nickname</label>
            <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Profile Picture</label><br>
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" width="80" style="border-radius: 8px; margin-bottom: 10px;">
            @endif
            <input type="file" name="avatar" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-control">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>

    {{-- <div class="text-center mt-4">
        <a href="{{ url('/user/two-factor-authentication') }}" class="btn btn-secondary">
            Manage Two-Factor Authentication
        </a>
    </div> --}}
    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
@endsection
