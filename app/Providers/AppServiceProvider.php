<?php

namespace App\Providers;

use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share title to each page
        $project_title = '| OMNIS System';
        $allAnneeAcademiques = AnneeAcademique::orderBy('id', 'desc')->get();
        session()->put('lastAnneeAcademique', AnneeAcademique::latest()->first());

        View::share('title', $project_title);
        View::share('allAnneeAcademiques', $allAnneeAcademiques);

        // On défini le "français" comme langue globale de Carbon
        \Carbon\Carbon::setLocale('fr');

        // Get cookie 
        view()->composer('layouts.informatique.master', function ($view) {
            $theme = Cookie::get('theme');
        
            if ($theme != 'dark-theme' && $theme != 'light') {
                $theme = 'light';
            }
        
            $view->with('theme', $theme);
        });
    }
}
