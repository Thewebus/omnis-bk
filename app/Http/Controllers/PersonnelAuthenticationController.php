<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonnelAuthenticationController extends Controller
{
    public function signIn() {
        return view('auth.personnel.login');
    }

    public function signUp() {
        return view('auth.personnel.sign-up');
    }

    public function authenticate(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('admins')->attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            $personnel = Personnel::where('email', $request->email)->first();

            if($personnel->type == 'comptable') {
                return redirect()->intended('comptable');
            }

            if($personnel->type == 'informaticien') {
                return redirect()->intended('informaticien');
            }

            return redirect()->intended('scolarite');
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.'
        ]);
    }

    public function logout() {
        Auth::guard('admins')->logout();
        return redirect()->route('index');
    }
}
