<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

       return back()->with([
           'data' => 'Estas credenciales son incorrectas',
       ]);
    }
}
