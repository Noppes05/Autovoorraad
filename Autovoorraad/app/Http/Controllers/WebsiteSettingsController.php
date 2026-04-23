<?php

namespace App\Http\Controllers;

use App\Actions\UpdateWebsiteSettings;
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
                'id' => $user->public_id,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

       $result =  UpdateWebsiteSettings::run($request, $user);

        return response()->json($result);
    }
}
