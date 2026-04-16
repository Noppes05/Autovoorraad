<?php

namespace App\Http\Controllers;

use App\Actions\StoreNewAuto;
use App\Actions\SyncAutoFotos;
use App\Enums\Auto_status;
use App\Models\auto;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AutoAPIController extends Controller
{
    /**
     * Display a listing of the Autos.
     */
    public function index()
    {
        $autos = auto::where('user_id', request()->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->get();

        return response()->json($autos->map(fn ($auto) => $this->normalizeAuto($auto))->values());
    }

    /**
     * shows a details of the car.
     */
    public function show(Request $request, $id)
    {
        $auto = auto::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();

        return response()->json($this->normalizeAuto($auto));
    }

    /**
     * Update the photos of the specified resource in storage.
     */
    public function update_fotos(Request $request, $id)
    {
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
        $auto = auto::where('id', $id)
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
            $fotos = $request->file('fotos', []);
            SyncAutoFotos::run($auto, $fotos, true);
        }

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

        return response()->json(['message' => 'Auto succesvol toegevoegd', 'auto_id' => $auto->id], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $carId = $request->input('car')['id'];
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

    // Helper method to normalize auto data for API responses.
    private function normalizeAuto(auto $auto): array
    {
        return [
            'id' => $auto->id,
            'kenteken' => $auto->kenteken,
            'merk' => $auto->merk,
            'model' => $auto->model,
            'prijs' => $auto->prijs,
            'km_stand' => $auto->km_stand,
            'bouwjaar' => $auto->bouwjaar,
            'beschrijving' => $auto->beschrijving,
            'status' => $auto->status,
            'created_at' => $auto->created_at,
            'fotos' => $auto->fotos->map(function ($foto) {
                return [
                    'id' => $foto->id,
                    'url' => asset('storage/'.$foto->foto_path),
                    'volgorde_nummer' => $foto->volgorde_nummer,
                ];
            })->values(),
        ];
    }
}
