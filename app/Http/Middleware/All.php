<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class All
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->type == 'informaticien' || Auth::user()->type == 'scolarite' || Auth::user()->type == 'professeur' || Auth::user()->type == 'etudiant') {
            return $next($request);
        }

        flashy()->error('Vous n\'êtes pas autorisé à accéder à cette page !');
        return redirect()->back();     }
}
