@extends('layouts.main')

@section('content')
<h1 class="registerHeadline">Registrieren</h1>
<div class="hint">Mit <p class="required">gekennzeichnete Felder müssen ausgefüllt werden.</p></div>
<div class="registerContainer">
      <form method="POST" action="{{ url('/register') }}" class="registerForm">
        @csrf
        <div class="formGroupR">
            <label for="prename" class="label required">Vorname</label>
            <input type="text" name="prename" class="input" required>
            @error('prename')
                <div class="error">{{ $message }}</div>
            @enderror
            </div>
        <div class="formGroupR">
            <label for="lastname" class="label required">Nachname</label>
            <input type="text" name="lastname" class="input" required>
            @error('lastname')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="username" class="label required">Username</label>
            <input type="text" name="username" class="input" required>
            @error('username')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="street" class="label required">Straße</label>
            <input type="text" name="street" class="input">
            @error('street')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="housenumber" class="label required">Hausnummer</label>
            <input type="text" name="housenumber" class="input" required>
            @error('housenumber')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="postal_code" class="label required">Postleitzahl</label>
            <input type="text" name="postal_code" class="input" required>
            @error('postal_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="town" class="label required">Stadt</label>
            <input type="text" name="town" class="input" required>
            @error('town')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="email" class="label required">Email</label>
            <input type="email" name="email" class="input" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="password" class="label required">Passwort</label>
            <input type="password" name="password" class="input" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="formGroupR">
            <label for="password_confirmation" class="label required">Passwort bestätigen</label>
        <input type="password" name="password_confirmation" class="input" required>
         @error('password_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror
        </div>
        <button type="submit" class="registerBtn">Registrieren</button>
        </form>
        <div class="redirect">
            <a href="{{'login'}}" class="redirectBtn">Ich habe bereits einen Account</a>
        </div>
    </div>
@endsection