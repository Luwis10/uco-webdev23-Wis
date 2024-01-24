<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function form(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => ['required'],
                'password' => ['required'],
                'phone' => ['required'],
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'phone' => $request->phone] )) {
                $request->session()->regenerate();
                return redirect()->route('home');
            }

            return back()
                ->withErrors([
                    'alert' => 'Email atau password yang Anda berikan tidak cocok',
                ])
                ->onlyInput('email');
        }
        return view('login/form');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return back();
    }
}
