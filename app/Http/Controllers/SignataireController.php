<?php

namespace App\Http\Controllers;

use App\Models\Signataire;
use Illuminate\Http\Request;

class SignataireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signataires = Signataire::orderBy('fullname')->get();
        return view('informatique.signataires.index', compact('signataires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('informatique.signataires.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' => 'required|string|unique:signataires',
            'fonction' => 'required|string',
            // 'signataire' => 'boolean',
        ]);

        // Si la case signature est coché on met tous celui de tous les autres en false dans la base de données.
        if ($request->filled('signataire')) {
            Signataire::where('signataire', true)->update(['signataire' => false]);
            $data['signataire'] = true;
        }

        Signataire::create($data);
        flashy()->message('Enregistrement effectué avec succès !');
        return redirect()->route('admin.signataires.index');
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
        $signataire = Signataire::findOrFail($id);
        return view('informatique.signataires.edit', compact('signataire'));
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
        $signataire = Signataire::findOrFail($id);

        $data = $request->validate([
            'fullname' => 'required|unique:signataires,fullname,' . $signataire->id,
            'fonction' => 'required|string',
        ]);

        if ($request->filled('signataire')) {
            Signataire::where('signataire', true)->update(['signataire' => false]);
            $data['signataire'] = true;
        }
        else {
            $data['signataire'] = false;
        }

        $signataire->update($data);
        flashy()->message('Modification effectuée avec succès !');
        return redirect()->route('admin.signataires.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $signataire = Signataire::findOrFail($id);
        $signataire->delete();

        flashy()->warning('Suppression effectuée');
        return redirect()->back();
    }
}
