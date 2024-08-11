<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesseurAuthenticationController extends Controller
{
    public function signIn() {
        return view('auth.professeur.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('profs')->attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            return redirect()->intended('professeur');
        }

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('dashboard');
        // }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.'
        ]);
    }

    public function logout() {
        Auth::guard('profs')->logout();
        return redirect()->route('index');
    }
}
