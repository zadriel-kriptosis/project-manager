<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\RequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            return $request->process();
        } catch (RequestException $e) {
            $e->flashError();
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('home')->with('success_message', 'You have successfully logged out.');
    }


}

