<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salles = Salle::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.salle.index', compact('salles', 'master'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        return view('informatique.salle.create', compact('master'));
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
            'capacite' => 'required|integer',
            'batiment' => 'required|string',
        ]);

        Salle::create($request->all());

        flashy()->message('Salle ajoutée avec succès !');
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
        $salle = Salle::findOrFail($id);
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.salle.edit', compact('salle', 'master'));
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
            'capacite' => 'required|integer',
            'batiment' => 'required|string',
        ]);

        $salle = Salle::findOrFail($id);
        $salle->update($request->all());

        flashy()->message('Modification effectuée !');
        return redirect()->route('admin.salle.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();

        flashy()->message('Suppréssion effectuée !');
        return redirect()->back();
    }
}
