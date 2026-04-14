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

    public function show(Request $request, $id)
    {
        $auto = Auto::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();

        return response()->json($auto);
    }

    public function update_fotos(Request $request, $id)
    {
        $auto = Auto::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'fotos' => 'required|array|min:1',
            'fotos.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ]);

        $this->delete_auto_fotos($auto);
        $this->store_auto_fotos($auto, $request->file('fotos'));

        return response()->json(['message' => 'Foto\'s succesvol bijgewerkt.'], 200);
    }

    public function update_car(Request $request, $id)
    {
        $auto = Auto::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'kenteken' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bouwjaar' => 'required|integer',
            'beschrijving' => 'nullable|string',
            'prijs' => 'nullable|numeric',
            'km_stand' => 'nullable|integer',
            'status' => 'required|in:beschikbaar,concept,verkocht',
            'replace_fotos' => 'nullable|boolean',
            'fotos' => 'required_if:replace_fotos,1|array|min:1',
            'fotos.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ]);

        $auto->update([
            'kenteken' => $request->input('kenteken'),
            'merk' => $request->input('merk'),
            'model' => $request->input('model'),
            'bouwjaar' => $request->input('bouwjaar'),
            'beschrijving' => $request->input('beschrijving'),
            'prijs' => $request->input('prijs'),
            'km_stand' => $request->input('km_stand'),
            'status' => $request->input('status'),
        ]);

        if ($request->boolean('replace_fotos')) {
            $this->delete_auto_fotos($auto);

            $fotos = $request->file('fotos', []);
            if (!empty($fotos)) {
                $this->store_auto_fotos($auto, $fotos);
            }
        }

        return response()->json([
            'message' => 'Auto succesvol bijgewerkt.',
            'auto_id' => $auto->id,
        ], 200);
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
            return redirect()->route('auto.detail', ['id' => $auto->id])->with('success', 'Auto succesvol opgeslagen als concept');
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
                    //delete old photos
                    $this->delete_auto_fotos($possibleauto);

                    //add the new photos
                    $fotos = $request->file('fotos');
                    $this->store_auto_fotos($possibleauto, $fotos);
            }

            return response()->json(['message' => 'Auto succesvol bijgewerkt', 'auto_id' => $possibleauto->id], 201);
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


    /**
     * Store a newly created resource in storage.
     */
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


    /**
     * Store the photos for the car
     */
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
     * delete fotos of the car
     */

    private function delete_auto_fotos($auto){
        $auto_fotos = AutoFoto::where('auto_id', $auto->id)->get();
        if($auto_fotos){
            foreach ($auto_fotos as $foto) {
                //delete de foto van de schijf
                Storage::disk('public')->delete($foto->foto_path);
                $foto->delete();
            }
        }
    }
    /**
     * Display the specified resource.
     */
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
    public function destroy(Request $request)
    {
        
        
        $carId = $request->input('car')['id'];
        $car = Auto::where('id', $carId)->where('user_id', $request->user()->id)->first();
        if (!$car) {
            return response()->json(['message' => 'Auto niet gevonden of je hebt geen toestemming om deze auto te verwijderen'], 404);
        }
        try {
            $this->delete_auto_fotos($car);
            $car->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Fout bij het verwijderen van de auto: ' . $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Auto succesvol verwijderd'], 200);
    }
}
