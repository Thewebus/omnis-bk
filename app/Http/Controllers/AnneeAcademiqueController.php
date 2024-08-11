<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use Illuminate\Http\Request;

class AnneeAcademiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anneeAcademiques = AnneeAcademique::orderBy('created_at', 'DESC')->get();
        return view('personnels.annee-academique.index', compact('anneeAcademiques'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('personnels.annee-academique.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'debut' => 'required|integer',
            'fin' => 'required|integer',
        ]);

        AnneeAcademique::create([
            'debut' => $request->debut,
            'fin' => $request->fin,
        ]);

        flashy()->message('Enrégistrement effectué !');
        return redirect()->route('admin.annee-academique.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anneeAcademique = AnneeAcademique::findOrFail($id);
        return view('personnels.annee-academique.edit', compact('anneeAcademique'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'debut' => 'required|integer',
            'fin' => 'required|integer',
        ]);

        $anneeAcademique = AnneeAcademique::findOrFail($id);
        $anneeAcademique->update([
            'debut' => $request->debut,
            'fin' => $request->fin,
        ]);

        flashy()->message('Enrégistrement effectué !');
        return redirect()->route('admin.annee-academique.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anneeAcademique = AnneeAcademique::findOrFail($id);
        $anneeAcademique->delete();

        flashy()->message('Suppression effectué !');
        return redirect()->route('admin.annee-academique.index');
    }
}
