<?php

namespace App\Http\Controllers;

use App\Enums\Auto_status;
use App\Models\auto;
use App\Models\Auto as ModelsAuto;
use App\Models\AutoFoto;
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
            'fotos.*'=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
            if ($request->has('fotos')) {
                $i = 1;
                $fotos = $request->file('fotos');
               
                foreach ($fotos as $foto) {
                    
                    $path = $foto->store('uploads', 'public');
                    $autofoto= AutoFoto::create([
                        'auto_id' => $auto->id,
                        'foto_path' => $path,
                        'volgorde_nummer' => $i,
                        ]);
                    $i++;
                }
            }
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
