<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateWebsiteSettings
{
    use AsAction;

    public function handle(Request $request, User $user)
    {
         $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kleur' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            'herofoto' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            'hero_beschrijving' => 'nullable|string',
            'telefoonnummer' => 'nullable|string|max:255',
            'plaats' => 'nullable|string|max:255',
            'adres' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
        ]);
        
        $user->name = $validated['naam'];
        $user->email = $validated['email'];
        if ($request->hasFile('logo')) {
            $user->logo = $this->uploadImage($request->file('logo'), 'logo') ?? $user->logo;
        }
        if ($request->hasFile('herofoto')) {
            $user->hero_foto = $this->uploadImage($request->file('herofoto'), 'herofoto') ?? $user->hero_foto;
        }
        $user->hero_beschrijving = $validated['hero_beschrijving'] ?? $user->hero_beschrijving;
        $user->kleur = $validated['kleur'] ?? $user->kleur;
        $user->telefoonnummer = $validated['telefoonnummer'] ?? $user->telefoonnummer;
        $user->plaats = $validated['plaats'] ?? $user->plaats;
        $user->adres = $validated['adres'] ?? $user->adres;
        $user->postcode = $validated['postcode'] ?? $user->postcode;

        try{
            $user->save();
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update website settings', 'message' => $e->getMessage()], 500);
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
    private function uploadImage($foto, $fieldName)
    {   
 
       if (!$foto) {
            return null;
        }
        if($fieldName === 'logo') {
           $path=  $foto->store('logos', 'public');
        } elseif ($fieldName === 'herofoto') {
           $path =  $foto->store('herofotos', 'public');
        }
      
        return $path;
    }
}
