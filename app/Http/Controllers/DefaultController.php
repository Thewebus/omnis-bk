<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function test() {
        return view('personnels.sample-page');
    }

    public function home() {
        return view('welcome');
    }

    public function setAnneeAcademique($id) {
        $anneeAcademique = AnneeAcademique::findOrFail($id);
        setSelectedAnneeAcademique($anneeAcademique);

        return back();
    }

}
