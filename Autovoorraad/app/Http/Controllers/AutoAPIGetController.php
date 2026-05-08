<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\FetchRdw;
use App\Models\Auto;


class AutoAPIGetController extends Controller
{
    /**
     * Fetch car data from RDW API by license plate.
     *
     * @return JsonResponse
     */
    public function fetchFromRdw(Request $request)
    {
        if (! $request->user()?->isPremium()) {
            return response()->json([
                'success' => false,
                'message' => 'Alleen premium gebruikers kunnen de RDW-koppeling gebruiken.',
            ], 403);
        }

        $request->validate([
            'kenteken' => 'required|string|max:10',
        ]);
        try {
            $vehicleData = FetchRdw::run($request->input('kenteken'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden bij het ophalen van de voertuiggegevens: '.$e->getMessage(),
            ], 500);
        }

        if (! $vehicleData) {
            return response()->json([
                'success' => false,
                'message' => 'Geen voertuiggegevens gevonden voor dit kenteken.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vehicleData,
        ]);
    }



     /**
     * shows a details of the car.
     */
    public function show(Request $request, $id)
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt opgehaald, daadwerkelijk toebehoort aan de ingelogde gebruiker.
        $auto = Auto::query()->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();

        return response()->json($this->normalizeAuto($auto));
    }


    /**
     * Display a listing of the Autos.
     */
    public function index()
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat alleen auto's worden opgehaald die toebehoren aan de ingelogde gebruiker.
        $autos = Auto::query()->where('user_id', request()->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->get();

        return response()->json($autos->map(fn ($auto) => $this->normalizeAuto($auto))->values());
    }

     // Helper method to normalize auto data for API responses.
    private function normalizeAuto(Auto $auto): array
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
