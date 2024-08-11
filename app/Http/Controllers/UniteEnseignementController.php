<?php

namespace App\Http\Controllers;

use App\Models\UniteEnseignement;
use Illuminate\Http\Request;

class UniteEnseignementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uniteEnseignements = UniteEnseignement::orderBy('nom', 'ASC')->get();
        return view('informatique.ue.index', compact('uniteEnseignements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('informatique.ue.create');
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
            'code' => 'required|string',
        ]);

        UniteEnseignement::create($request->all());
        flashy()->message('Enregistrement effectué avec sucèss !');
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
        $uniteEnseignement = UniteEnseignement::findOrFail($id);
        return view('informatique.ue.edit', compact('uniteEnseignement'));
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
            'code' => 'required|string',
        ]);

        $uniteEnseignement = UniteEnseignement::findOrFail($id);
        $uniteEnseignement->update($request->all());

        flashy()->message('Modification effectuée avec sucèss !');
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
        $uniteEnseignement = UniteEnseignement::findOrFail($id);
        $uniteEnseignement->delete();

        flashy()->message('Suppression effectuée !');
        return redirect()->back();
    }
}
