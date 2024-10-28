<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referred_by' => $data['referred_by'] ?? null,
        ]);
    }

    public function register(Request $request)
    {
        // Validate the input data
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate referral code
        $referralCode = Str::random(10);

        // Retrieve the employee role
        $role = Role::where('name', 'employee')->first();

        // Create the new user
        $createdUser = User::create([
            'id' => Str::uuid(),
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'mnemonic' => Str::random(20),
            'referral_code' => $referralCode,
            'referred_by' => null,
            'login2fa_id' => 0, // Default 2FA option
            'is_active' => true,
            'remember_token' => Str::random(10),
            'banned_until' => null, // No ban initially
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attach the employee role to the user
        $createdUser->roles()->attach($role->id);

        // Log in the newly created user
        Auth::login($createdUser);

        // Redirect to home
        return redirect()->route('home');
    }
}
