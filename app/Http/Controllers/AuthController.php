<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $user = User::where(['email' => $request->input('username'), 'password' => $request->input('password')])->first();
        if ($user) {
            Auth::login($user);
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }
}
