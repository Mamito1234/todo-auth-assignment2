@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Please Verify Your Email</h2>
    <p>Before proceeding, please check your email for a verification link.</p>

    @if (session('status') == 'verification-link-sent')
        <div style="color: green; margin-top: 10px;">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary mt-3">Resend Verification Email</button>
    </form>
</div>
@endsection
