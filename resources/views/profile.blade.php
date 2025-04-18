@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2 class="mb-4">User Profile</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('todo.index') }}" style="display:inline-block; margin-bottom:20px;">&larr; Back to To-Do List</a>

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

    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
@endsection
