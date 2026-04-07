<?php

namespace App\Http\Controllers;

use App\Auto_status;
use App\Models\auto;
use Illuminate\Http\Request;

class AutoAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kenteken' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bouwjaar' => 'required|integer',
            'beschrijving'=> 'nullable|string',
            'prijs'=>'nullable|numeric',
            'km_stand'=>'nullable|integer',
            'fotos'=> 'nullable|array',
        ]);
    try{
        $auto = Auto::create([
            'user_id' => $request->user()->id,
            'kenteken' => $request->input('kenteken'),
            'merk' => $request->input('merk'),
            'model' => $request->input('model'),
            'bouwjaar' => $request->input('bouwjaar'),
            'beschrijving' => $request->input('beschrijving'),
            'prijs' => $request->input('prijs'),
            'km_stand' => $request->input('km_stand'),
            'status'=> Auto_status::BESCHIKBAAR,
        ]);
    }
    catch(\Exception $e){
        return response()->json(['message' => 'Fout bij het toevoegen van de auto: ' . $e->getMessage()], 500);
    }

        return response()->json(['message' => 'Auto succesvol toegevoegd', 'auto_id' => $auto->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(auto $auto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, auto $auto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(auto $auto)
    {
        //
    }
}
