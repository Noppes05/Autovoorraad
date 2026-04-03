<?php

namespace App\Http\Controllers;

use App\Services\RdWService;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    /**
     * Show the page to add a car.
     */
    public function AutoToevoegen()
    {
        return view('Auto_toevoegen');
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
