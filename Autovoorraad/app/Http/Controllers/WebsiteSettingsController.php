<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
  public function index(Request $request)
    {
        //return user()->id;
        return view('Website_Settings', [
            'user' => $request->user()->id,
        ]);
    }

    public function get(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'user_id' => 'required|uuid',
        ]);

        if ($user->id !== $request->input('user_id')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'settings' => [
                'naam' => $user->name,
                'logo' => $user->logo,
                'kleur' => $user->kleur ?? null,
                'herofoto' => $user->hero_foto,
                'hero_beschrijving' => $user->hero_beschrijving,
                'telefoonnummer' => $user->telefoonnummer,
                'Email' => $user->email,
                'plaats' => $user->plaats,
                'adres' => $user->adres,
                'postcode' => $user->postcode,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|string|max:255',
            'herofoto' => 'nullable|string|max:255',
            'hero_beschrijving' => 'nullable|string',
            'telefoonnummer' => 'nullable|string|max:255',
            'plaats' => 'nullable|string|max:255',
            'adres' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
        ]);

        $user->name = $validated['naam'];
        $user->email = $validated['email'];
        $user->logo = $validated['logo'] ?? $user->logo;
        $user->hero_foto = $validated['herofoto'] ?? $user->hero_foto;
        $user->hero_beschrijving = $validated['hero_beschrijving'] ?? $user->hero_beschrijving;
        $user->telefoonnummer = $validated['telefoonnummer'] ?? $user->telefoonnummer;
        $user->plaats = $validated['plaats'] ?? $user->plaats;
        $user->adres = $validated['adres'] ?? $user->adres;
        $user->postcode = $validated['postcode'] ?? $user->postcode;

        $user->save();

        return response()->json([
            'success' => true,
            'settings' => [
                'naam' => $user->name,
                'logo' => $user->logo,
                'kleur' => $user->kleur ?? null,
                'herofoto' => $user->hero_foto,
                'hero_beschrijving' => $user->hero_beschrijving,
                'telefoonnummer' => $user->telefoonnummer,
                'Email' => $user->email,
                'plaats' => $user->plaats,
                'adres' => $user->adres,
                'postcode' => $user->postcode,
            ],
        ]);
    }
}
