<?php

namespace App\Http\Controllers;

use App\Services\RdWService;
use Illuminate\Http\Request;
use App\Models\Auto;
use App\Models\AutoFoto;
use Illuminate\Container\Attributes\Auth;

class AutoController extends Controller
{
    /**
     * Show the page to add a car.
     */
    public function AutoToevoegen()
    {
        return view('Auto_toevoegen');
    }


    public function details($id)
    {
        $auto = Auto::where('id', $id)
            ->where('user_id', request()->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();

        $initialFotos = $auto->fotos
            ->map(function ($foto) {
                return [
                    'id' => $foto->id,
                    'url' => asset('storage/' . $foto->foto_path),
                ];
            })
            ->values()
            ->toArray();

        return view('Auto_details', [
            'initialFotos' => $initialFotos,
        ]);
    }

    public function edit($id)
    {
        $auto = Auto::where('id', $id)
            ->where('user_id', request()->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();

        $initialFotos = $auto->fotos
            ->map(function ($foto) {
                return [
                    'id' => $foto->id,
                    'url' => asset('storage/' . $foto->foto_path),
                ];
            })
            ->values()
            ->toArray();

        return view('Auto_bewerken', [
            'auto' => $auto,
            'initialFotos' => $initialFotos,
        ]);
    }

    public function manageFotos($id)
    {
        $auto = Auto::where('id', $id)
            ->where('user_id', request()->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();

        $initialFotos = $auto->fotos
            ->map(function ($foto) {
                return [
                    'id' => $foto->id,
                    'url' => asset('storage/' . $foto->foto_path),
                ];
            })
            ->values()
            ->toArray();

        return view('Auto_fotos_beheer', [
            'autoId' => $auto->id,
            'initialFotos' => $initialFotos,
        ]);
    }

    /**
     * Fetch car data from RDW API by license plate.
     *
     * @param Request $request
     * @param RdwService $rdwService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchFromRdw(Request $request, RdwService $rdwService)
    {
        $request->validate([
            'kenteken' => 'required|string|max:10'
        ]);

        $kenteken = $request->input('kenteken');

        $vehicleData = $rdwService->getVehicleData($kenteken);
        
        if (!$vehicleData) {
            return response()->json([
                'success' => false,
                'message' => 'Geen voertuiggegevens gevonden voor dit kenteken.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vehicleData
        ]);
    }
}
