@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px;">
    <h2 class="mb-4">Two-Factor Authentication</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="mb-3">
            <label for="code" class="form-label">Authentication Code</label>
            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" autofocus required>

            @error('code')
                <span class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <p class="text-muted mb-3">Alternatively, enter one of your recovery codes:</p>

        <div class="mb-3">
            <label for="recovery_code" class="form-label">Recovery Code</label>
            <input id="recovery_code" type="text" class="form-control @error('recovery_code') is-invalid @enderror" name="recovery_code">

            @error('recovery_code')
                <span class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Authenticate</button>
        </div>
    </form>
</div>
@endsection
