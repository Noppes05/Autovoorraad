<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicApiController extends Controller
{
     public function Getautos(Request $request)
    {
        $tenant = $request->attributes->get('tenant');
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }
        $user = $tenant['tenant'];
        if($user->public_id != $request->input('user_id')) {
            dd($user->public_id, $request->input('user_id'));
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $autos = $user->autos()
            ->where('status', '!=', 'concept')
            ->with('fotos')
            ->get()
            ->map(function ($auto) {
            return [
                'id' => $auto->public_id,
                'merk' => $auto->merk,
                'model' => $auto->model,
                'prijs' => $auto->prijs,
                'km_stand' => $auto->km_stand,
                'bouwjaar' => $auto->bouwjaar,
                'status' => $auto->created_at && $auto->created_at->greaterThanOrEqualTo(now()->subWeek())
                    ? 'net nieuw'
                    : $auto->status,
                'fotos' => $auto->fotos
                    ->where('volgorde_nummer', 1)
                    ->map(function ($foto) {
                        return [
                            'url' => asset($foto->foto_path),
                        ];
                    })->values(),
            ];
            });

        return response()->json([
            'success' => true,
            'autos' => $autos,
        ]);
    }
    public function GetAutoDetail(Request $request)
    {
        $tenant = $request->attributes->get('tenant');
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }
        $user = $tenant['tenant'];
        $publicId = $request->input('public_id');

        $auto = $user->autos()
            ->where('status', '!=', 'concept')
            ->where('public_id', $publicId)
            ->with('fotos')
            ->first();

        if (!$auto) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        return response()->json([
            'success' => true,
            'auto' => [
                'id' => $auto->public_id,
                'merk' => $auto->merk,
                'model' => $auto->model,
                'prijs' => $auto->prijs,
                'km_stand' => $auto->km_stand,
                'bouwjaar' => $auto->bouwjaar,
                'kenteken' => $auto->kenteken,
                'beschrijving' => $auto->beschrijving,
                'status' => $auto->created_at && $auto->created_at->greaterThanOrEqualTo(now()->subWeek())
                    ? 'net nieuw'
                    : $auto->status,
                'fotos' => $auto->fotos
                    ->sortBy('volgorde_nummer')
                    ->map(function ($foto) {
                        return [
                            'url' => asset($foto->foto_path),
                        ];
                    })->values(),
            ],
        ]);
    }
}
