<?php

namespace App\Http\Controllers;

use App\Models\Institut;
use Illuminate\Http\Request;

class institutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instituts = Institut::orderBy('nom', 'ASC')->get();
        return view('informatique.institut.index', compact('instituts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('informatique.institut.create');
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
            'description' => 'nullable|string',
        ]);

        Institut::create($request->all());
        flashy()->message('Enrégistrement effectué !');
        return redirect()->route('admin.institut.index');
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
        $institut = Institut::findOrFail($id);
        return view('informatique.institut.edit', compact('institut'));
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
            'description' => 'nullable|string',
        ]);

        $institut = Institut::findOrFail($id);

        $institut->update($request->all());
        flashy()->message('Enrégistrement effectué !');
        return redirect()->route('admin.institut.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institut = Institut::findOrFail($id);
        $institut->delete();
        flashy()->success('Element supprimé avec succès');
        return redirect()->back();
    }
}
