<?php

namespace App\Http\Controllers;

use App\Enums\Auto_status;
use App\Models\auto;
use App\Models\Auto as ModelsAuto;
use App\Models\AutoFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage ;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AutoAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auto::where('user_id', request()->user()->id)->with('fotos')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_concept(Request $request)
    {
        try{
            $auto = $this->store_car($request, Auto_status::CONCEPT);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: ' . $e->getMessage()], 500);
        }
        catch(UnprocessableEntityHttpException $e){
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: ' . $e->getMessage()], 422);
        }
            return response()->json(['message' => 'Auto succesvol toegevoegd', 'auto_id' => $auto->id], 201);
    }

    public function store_beschikbaar(Request $request)
    {
      try{
        $possibleauto= Auto::where('user_id', $request->user()->id)
        ->where('kenteken', $request->input('kenteken'))
        ->where('status',Auto_status::CONCEPT)
        ->first();

        //update car if it exists, otherwise create new car
        if($possibleauto){
            $request->validate([
                'merk' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'bouwjaar' => 'required|integer',
                'beschrijving'=> 'nullable|string',
                'prijs'=>'nullable|numeric',
                'km_stand'=>'nullable|integer',
                'fotos.*'=> 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            ]);
            $possibleauto->update([
                'merk' => $request->input('merk'),
                'model' => $request->input('model'),
                'bouwjaar' => $request->input('bouwjaar'),
                'beschrijving' => $request->input('beschrijving'),
                'prijs' => $request->input('prijs'),
                'km_stand' => $request->input('km_stand'),
                'status'=> Auto_status::BESCHIKBAAR,
            ]);
            if ($request->has('fotos')) {

                //delete old foto's
                $possibleauto_fotos = AutoFoto::where('auto_id', $possibleauto->id)->get();
                if($possibleauto_fotos){
                    foreach ($possibleauto_fotos as $foto) {
                        //delete de foto van de schijf
                        Storage::disk('public')->delete($foto->foto_path);
                        $foto->delete();
                    }
                }

                //add the new photos
                $fotos = $request->file('fotos');
                $this->store_auto_fotos($possibleauto, $fotos);
            }

            return response()->json(['message' => 'Auto succesvol bijgewerkt', 'auto_id' => $possibleauto->id], 200);
        }
           $auto = $this->store_car($request, Auto_status::BESCHIKBAAR);
        }
        catch(\Exception $e){
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: ' . $e->getMessage()], 422);
        }
        catch(UnprocessableEntityHttpException $e){
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: ' . $e->getMessage()], 422);
        }

            return response()->json(['message' => 'Auto succesvol toegevoegd', 'auto_id' => $auto->id], 201);
    }

    private function store_car(Request $request, Auto_status $status){
         $request->validate([
            'kenteken' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bouwjaar' => 'required|integer',
            'beschrijving'=> 'nullable|string',
            'prijs'=>'nullable|numeric',
            'km_stand'=>'nullable|integer',
            'fotos.*'=> 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ]);
        $existingAuto = ModelsAuto::where('kenteken', $request->input('kenteken'))
        ->where('user_id',$request->user()->id)
        ->whereNot('status', Auto_status::VERKOCHT)
        ->first();
        if ($existingAuto) {
            throw new UnprocessableEntityHttpException('Er bestaat al een auto met dit kenteken en gebruiker die niet verkocht is.');
        }
        $auto = Auto::create([
            'user_id' => $request->user()->id,
            'kenteken' => $request->input('kenteken'),
            'merk' => $request->input('merk'),
            'model' => $request->input('model'),
            'bouwjaar' => $request->input('bouwjaar'),
            'beschrijving' => $request->input('beschrijving'),
            'prijs' => $request->input('prijs'),
            'km_stand' => $request->input('km_stand'),
            'status'=> $status,
            ]);
            if ($request->has('fotos')) {
                $fotos = $request->file('fotos');
                try{
                $this->store_auto_fotos($auto, $fotos);
                }
                catch(\Exception $e){
                    //delete the auto if there was an error uploading the photos
                    $auto->delete();
                    throw new UnprocessableEntityHttpException("Fout bij het uploaden van de foto's: " . $e->getMessage());
                }
            }
            return $auto;
    }

    private function store_auto_fotos($auto, $fotos){
        $i = 1;
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
