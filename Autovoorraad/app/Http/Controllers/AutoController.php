<?php

namespace App\Http\Controllers;

use App\Actions\FetchRdw;
use App\Models\Auto;
use App\Services\RdWService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jdkweb\RdwApi\Controllers\RdwApiRequest;
use Jdkweb\RdwApi\Enums\Endpoints;
use Jdkweb\RdwApi\Enums\Interface\OutputFormat;
use Jdkweb\RdwApi\Enums\OutputFormats;
use phpDocumentor\Reflection\Types\This;

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
     * Show the page to see details of a car.
     */
    public function details($id)
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt opgehaald, daadwerkelijk toebehoort aan de ingelogde gebruiker.
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
                    'url' => asset('storage/'.$foto->foto_path),
                ];
            })
            ->values()
            ->toArray();

        return view('Auto_details', [
            'initialFotos' => $initialFotos,
        ]);
    }

    /**
     * Show the page to edit a car.
     */
    public function edit($id)
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt opgehaald, daadwerkelijk toebehoort aan de ingelogde gebruiker.
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
                    'url' => asset('storage/'.$foto->foto_path),
                ];
            })
            ->values()
            ->toArray();

        return view('Auto_bewerken', [
            'auto' => $auto,
            'initialFotos' => $initialFotos,
        ]);
    }

    // Show the page to manage photos of a car.
    public function manageFotos($id)
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt opgehaald, daadwerkelijk toebehoort aan de ingelogde gebruiker.
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
                    'url' => asset('storage/'.$foto->foto_path),
                ];
            })
            ->values()
            ->toArray();

        return view('Auto_fotos_beheer', [
            'autoId' => $auto->id,
            'initialFotos' => $initialFotos,
        ]);
    }
}
