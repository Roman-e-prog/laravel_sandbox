<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
// Request $request → Laravel auto-injects the HTTP request object.
use App\Models\User;
//Bring in the User Model
use Illuminate\Support\Facades\Hash;
// Hash::make() → secure password hashing.
use Illuminate\Support\Facades\Auth;
// Auth::attempt() → checks credentials.
use App;

class AuthController extends Controller
{
    public function register(Request $request)
    {
           $validated = $request->validate([
        'prename' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'username' => 'required|string|unique:users|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);
    // dd($validated);
        $user = User::create([
            'prename' => $validated['prename'],
            'lastname' => $validated['lastname'],
            'username' => $validated['username'],
            'street' => $request->street,
            'housenumber' => $request->housenumber,
            'postal_code' => $request->postal_code,
            'town' => $request->town,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please log in.');

    }

    public function login(Request $request)
    {
        $request->validate(
            [ 'email' => ['required', 'email'], 
            'password' => ['required'], ]
        );
        if (!Auth::attempt($request->only('email', 'password'))) { 
            return back() ->with('error', 'Falsche Eingabedaten!') ->withInput(); }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->tokens()->latest()->first()->update(['expires_at'=>now()->addMinutes(15)]);
        // createToken() → Sanctum generates a JWT-like token for API use.
         // Refresh token (long-lived)
            $refreshToken = $user->createToken('refresh')->plainTextToken;
            $user->tokens()->latest()->first()->update([
                'expires_at' => now()->addDays(7),
            ]);
            return redirect('/')->with('success', 'Login successful!');
        
    }
    public function refresh(Request $request)
{
    $refreshToken = $request->bearerToken(); // client sends Authorization: Bearer <refresh_token>

    $token = PersonalAccessToken::findToken($refreshToken);

    if (!$token || $token->name !== 'refresh' || $token->expires_at->isPast()) {
        return response()->json(['error' => 'Invalid or expired refresh token'], 401);
    }

    $user = $token->tokenable;

    // Issue new access token
    $newAccessToken = $user->createToken('access')->plainTextToken;
    $user->tokens()->latest()->first()->update([
        'expires_at' => now()->addMinutes(15),
    ]);

   return response()->json([
            'access_token' => $token, 
            'refresh_token' => $refreshToken, 
            'token_type' => 'Bearer', 
            'user'=>$user]);
    
}


    public function logout(Request $request)
{
    if ($request->user()->currentAccessToken()) {
        $request->user()->currentAccessToken()->delete(); // API logout
        return response()->json(['success' => true]);
    }

    Auth::logout(); // Session logout
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('status', 'Logged out successfully');
}
};

