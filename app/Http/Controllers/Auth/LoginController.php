<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        if (Auth::user()->type == 'etudiant') {
            return '/etudiant';
        }
    }

    public function parentLoginPage() {
        return view('auth.login-parent');
    }

    public function loginParent(Request $request) {
        $this->validate($request, [
            'matricule' => 'required|exists:users,matricule_etudiant',
        ]);

        $etudiant = User::where('matricule_etudiant', $request->matricule)->first();
        if(!is_null($etudiant)) {
            Auth::login($etudiant);
            return redirect()->route('user.dashboard-etudiant');
        }
        else {
            dd('Something gone wrong');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['numero_etudiant' => $request->get('email'), 'password' => $request->get('password')];
        }

        if(ctype_alnum($request->get('email'))) {
            dd('je suis le matricule');
        }
        // else {
        //     return ['numero_etudiant' => $request->get('email'), 'password' => $request->get('password')];
        // }
        return $request->only($this->username(), 'password');
    }
}
