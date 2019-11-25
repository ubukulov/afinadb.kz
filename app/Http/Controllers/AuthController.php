<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $user = User::where(['email' => $request->input('username'), 'password' => $request->input('password')])->first();
        if ($user && $user->deleted == '1') {
            Auth::login($user);
            $_token = Str::random(60);
            if (empty($user->api_token)) {
                $user->api_token = $_token;
                $user->save();
            } else {
                $user->api_token = $_token;
                $user->save();
            }
            return redirect()->route('home');
        } elseif ($user && $user->deleted == '0') {
            flash('Ваш аккаунт заблокировано.')->warning();
            return redirect()->back();
        } else {
            flash('Логин или пароль не правильно')->error();
            return redirect()->back();
        }
    }
}
