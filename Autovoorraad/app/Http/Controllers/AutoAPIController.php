<?php

namespace App\Http\Controllers;

use App\Actions\StoreNewAuto;
use App\Actions\UpdateCar;
use App\Actions\SyncAutoFotos;
use App\Enums\Auto_status;
use App\Models\auto;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AutoAPIController extends Controller
{
  

    /**
     * Update the photos of the specified resource in storage.
     */
    public function update_fotos(Request $request, $id)
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt bijgewerkt, daadwerkelijk toebehoort aan de ingelogde gebruiker.
        $auto = auto::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'fotos' => 'required|array|min:1',
            'fotos.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ]);

        SyncAutoFotos::run($auto, $request->file('fotos', []), true);

        return response()->json(['message' => 'Foto\'s succesvol bijgewerkt.'], 200);
    }

    /**
     * Update the car details of the specified resource in storage.
     */
    public function update_car(Request $request, $id)
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt bijgewerkt, daadwerkelijk toebehoort aan de ingelogde gebruiker.
        $auto = auto::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        UpdateCar::run($request, $auto);

        return response()->json([
            'message' => 'Auto succesvol bijgewerkt.',
            'auto_id' => $auto->id,
        ], 200);
    }

    /**
     * Store a newly created resource with status CONCEPT in storage.
     */
    public function store_concept(Request $request)
    {
        try {
            $auto = StoreNewAuto::run($request, Auto_status::CONCEPT);
        } 
        catch (UnprocessableEntityHttpException $e) {
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: '.$e->getMessage()], 422);
        } 
        catch (\Exception $e) {
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: '.$e->getMessage()], 500);
        }

        return redirect()->route('auto.detail', ['id' => $auto->id])->with('success', 'Auto succesvol opgeslagen als concept');
    }

    /**
     * Store a newly created resource with status BESCHIKBAAR in storage.
     */
    public function store_beschikbaar(Request $request)
    {
        try {
            $auto = StoreNewAuto::run($request, Auto_status::BESCHIKBAAR);
        } 
        catch (UnprocessableEntityHttpException $e) {
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: '.$e->getMessage()], 422);
        } 
        catch (\Exception $e) {
            return response()->json(['message' => 'Fout bij het toevoegen van de auto: '.$e->getMessage()], 500);
        }

        return redirect()->route('auto.detail', ['id' => $auto->id])->with('success', 'Auto succesvol opgeslagen als beschikbaar');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $carId = $request->input('car')['id'];
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt verwijderd, daadwerkelijk toebehoort aan de ingelogde gebruiker.
        $car = auto::where('id', $carId)->where('user_id', $request->user()->id)->first();
        if (! $car) {
            return response()->json(['message' => 'Auto niet gevonden of je hebt geen toestemming om deze auto te verwijderen'], 404);
        }
        try {
            SyncAutoFotos::run($car, [], true);
            $car->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Fout bij het verwijderen van de auto: '.$e->getMessage()], 500);
        }

        return response()->json(['message' => 'Auto succesvol verwijderd'], 200);
    }
}
