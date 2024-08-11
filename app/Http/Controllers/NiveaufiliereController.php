<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\NiveauFiliere;
use Illuminate\Http\Request;

class NiveaufiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nom' => 'required|string',
            'scolarite_affecte' => 'required|integer',
            'scolarite_reaffecte' => 'required|integer',
            'scolarite_nonaffecte' => 'required|integer',
            'filiere_id' => 'required|integer',
        ]);

        NiveauFiliere::create($request->all());

        flashy()->message('Enrégistrement effectuée !');
        return redirect()->back();
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
        //
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
            'nom' => 'required|string',
            'scolarite_affecte' => 'required|integer',
            'scolarite_reaffecte' => 'required|integer',
            'scolarite_nonaffecte' => 'required|integer',
            'filiere_id' => 'required|integer',
        ]);

        $niveauFiliere = NiveauFiliere::findOrFail($id);
        $niveauFiliere->update($request->all());

        flashy()->message('Modification effectuée !');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $niveauFiliere = NiveauFiliere::findOrFail($id);
        $niveauFiliere->delete();
        flashy()->message('Suppresion effectuée !');
        return redirect()->back();
    }
}
