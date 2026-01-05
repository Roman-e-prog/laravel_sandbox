@extends('layouts.main')

@section('content')
<h1 class="loginHeadline">Login</h1>
<div class="loginContainer">
      <form method="POST" action="{{ url('/login') }}" class="registerForm">
        @csrf
        <div class="formGroupR">
            <label for="email" class="label required">Email</label>
            <input type="email" name="email" placeholder="Email" class="input" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="password" class="label required">Passwort</label>
        <input type="password" name="password" class="input" required>
        </div>
        <button type="submit" class="loginBtn">Login</button>
        </form>
        <div class="forgottenWrapper">
            <a href="{{'password-forgotten'}}" class="forgottenBtn">Passwort vergessen</a>
        </div>
    </div>
@endsection