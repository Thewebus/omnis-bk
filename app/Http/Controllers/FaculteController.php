<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use App\Models\Institut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaculteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facultes = Faculte::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.faculte.index', compact('facultes', 'master'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $instituts = Institut::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';

        return view('informatique.faculte.create', compact('instituts', 'master'));
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
            'institut' => 'required|integer',
            'nom_faculte' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $faculte = Faculte::create([
            'nom' => $request->nom_faculte,
            'description' => $request->description,
            'institut_id' => $request->institut,
        ]);

        flashy()->success('Element enregistré avec succès');
        return redirect()->route('admin.facultes.edit', $faculte->id);
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
        $faculte =  Faculte::findOrFail($id);
        $instituts = Institut::orderBy('nom', 'ASC')->get();
        Auth::user()->type == 'informaticien' ? $master = 'informatique' : $master = 'personnel';
        
        return view('informatique.faculte.edit', compact('faculte', 'instituts', 'master'));
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
            'institut' => 'required|integer',
            'nom_faculte' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $faculte =  Faculte::findOrFail($id);
        $faculte->update([
            'nom' => $request->nom_faculte,
            'description' => $request->description,
            'institut_id' => $request->institut,
        ]);

        flashy()->success('Modification éffectuée avec succès');
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
        $faculte =  Faculte::findOrFail($id);
        $faculte->delete();

        flashy()->warning('Suppression effectuée');
        return redirect()->back();
    }
}
