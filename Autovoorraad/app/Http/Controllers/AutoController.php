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
        $auto = Auto::where('id', $id)->with('fotos')->firstOrFail();
        if($auto->user_id !== request()->user()->id){
            abort(403);
        }
        return view('Auto_details', ['auto' => $auto]);
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
