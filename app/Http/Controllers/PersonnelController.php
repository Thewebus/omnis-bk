<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Personnel;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels = Personnel::orderBy('fullname', 'ASC')->get();
        return view('informatique.personnels.index', compact('personnels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::orderBy('nom', 'ASC')->get();
        return view('informatique.personnels.create', compact('services'));
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
            'nom_prenoms' => 'required|string',
            'numero' => 'required|digits:10|unique:personnels,numero',
            'email' => 'required|email',
            'role' => 'required|in:comptable,informaticien,scolarite',
            'service' => 'required|integer',
        ]);

        $password = Str::random(10);

        $personnel = Personnel::create([ 
            'fullname' => $request->nom_prenoms,
            'numero' => $request->numero,
            'email' => $request->email,
            'type' => $request->role,
            'password' => Hash::make($password),
            'service_id' => $request->service,
        ]);

        $details['fullname'] = $personnel->fullname;
        $details['email'] = $personnel->email;
        $details['password'] = $password;
  
        dispatch(new SendEmailJob($details));

        flashy()->message('Enregistement effectuée ! Un mail lui a été envoyé.');
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
        $personnel = Personnel::findOrFail($id);
        return view('informatique.personnels.show', compact('personnel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $personnel = Personnel::findOrFail($id);
        $services = Service::orderBy('nom', 'ASC')->get();
        
        return view('informatique.personnels.edit', compact('personnel', 'services'));
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
        $personnel = Personnel::findOrFail($id);

        $this->validate($request, [
            'nom_prenoms' => 'required|string',
            'numero' => 'required|digits:10|unique:personnels,numero,' . $personnel->id,
            'email' => 'required|email',
            'role' => 'required|in:comptable,informaticien,scolarite',
            'service' => 'required|integer',
        ]);

        $personnel->update([
            'fullname' => $request->nom_prenoms,
            'numero' => $request->numero,
            'email' => $request->email,
            'type' => $request->role,
            'service_id' => $request->service,
        ]);

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
        $personnel = Personnel::findOrFail($id);
        $personnel->delete();
        flashy()->message('Suppression effectuée !');
        return redirect()->back();
    }
}
