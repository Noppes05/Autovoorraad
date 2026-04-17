<?php

namespace App\Actions;

use App\Enums\Auto_status;
use App\Models\Auto;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class StoreNewAuto
{
    use AsAction;

    public function handle(Request $request, Auto_status $status): Auto
    {
        $this->validateRequest($request, $status);

        if ($status === Auto_status::BESCHIKBAAR) {
            $conceptAuto = $this->findConceptAuto($request);

            if ($conceptAuto) {
                return $this->updateConceptToBeschikbaar($request, $conceptAuto);
            }
        }

        return $this->createNewAuto($request, $status);
    }

    private function validateRequest(Request $request, Auto_status $status): void
    {
        $rules = [
            'kenteken' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bouwjaar' => 'required|integer',
            'beschrijving' => 'nullable|string',
            'prijs' => 'nullable|numeric',
            'km_stand' => 'nullable|integer',
            'fotos.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ];

        if ($status === Auto_status::BESCHIKBAAR) {
            $rules['fotos'] = 'sometimes|array|min:1';
        }

        $request->validate($rules);
    }

    private function findConceptAuto(Request $request): ?Auto
    {
        // T1- Threat tenant Data leak: Zorg ervoor dat de auto die wordt opgehaald, daadwerkelijk toebehoort aan de ingelogde gebruiker.
        return Auto::where('user_id', $request->user()->id)
            ->where('kenteken', $request->input('kenteken'))
            ->where('status', Auto_status::CONCEPT)
            ->first();
    }

    private function updateConceptToBeschikbaar(Request $request, Auto $conceptAuto): Auto
    {
        $conceptAuto->update([
            'merk' => $request->input('merk'),
            'model' => $request->input('model'),
            'bouwjaar' => $request->input('bouwjaar'),
            'beschrijving' => $request->input('beschrijving'),
            'prijs' => $request->input('prijs'),
            'km_stand' => $request->input('km_stand'),
            'status' => Auto_status::BESCHIKBAAR,
        ]);

        if ($request->has('fotos')) {
            $fotos = $request->file('fotos', []);
            SyncAutoFotos::run($conceptAuto, $fotos, true);
        }

        return $conceptAuto;
    }

    private function createNewAuto(Request $request, Auto_status $status): Auto
    {
        $existingAuto = Auto::where('kenteken', $request->input('kenteken'))
            ->where('user_id', $request->user()->id)
            ->where('status', '!=', Auto_status::VERKOCHT)
            ->first();

        if ($existingAuto) {
            throw new UnprocessableEntityHttpException('Er bestaat al een auto met dit kenteken en gebruiker die niet verkocht is.');
        }

        $auto = Auto::create([
            'user_id' => $request->user()->id,
            'kenteken' => $request->input('kenteken'),
            'merk' => $request->input('merk'),
            'model' => $request->input('model'),
            'bouwjaar' => $request->input('bouwjaar'),
            'beschrijving' => $request->input('beschrijving'),
            'prijs' => $request->input('prijs'),
            'km_stand' => $request->input('km_stand'),
            'status' => $status,
        ]);

        if ($request->has('fotos')) {
            $fotos = $request->file('fotos', []);

            if (! empty($fotos)) {
                try {
                    SyncAutoFotos::run($auto, $fotos, false);
                } catch (\Exception $e) {
                    // Remove the just-created auto if one of the photo operations fails.
                    $auto->delete();
                    throw new UnprocessableEntityHttpException("Fout bij het uploaden van de foto's: ".$e->getMessage());
                }
            }
        }

        return $auto;
    }
}
