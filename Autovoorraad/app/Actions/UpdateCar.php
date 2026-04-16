<?php

namespace App\Actions;

use App\Enums\Auto_status;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UpdateCar
{
    use AsAction;

    public function handle(Request $request, Auto $auto): Auto
    {
        $this->validateRequest($request, $auto);

        return DB::transaction(function () use ($request, $auto) {
            $auto->update([
                'kenteken' => $request->input('kenteken'),
                'merk' => $request->input('merk'),
                'model' => $request->input('model'),
                'bouwjaar' => $request->input('bouwjaar'),
                'beschrijving' => $request->input('beschrijving'),
                'prijs' => $request->input('prijs'),
                'km_stand' => $request->input('km_stand'),
                'status' => $request->input('status'),
            ]);

            if ($request->boolean('replace_fotos')) {
                SyncAutoFotos::run($auto, $request->file('fotos', []), true);
            }

            return $auto;
        });
    }

    private function validateRequest(Request $request, Auto $auto): void
    {
        $request->validate([
            'kenteken' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bouwjaar' => 'required|integer',
            'beschrijving' => 'nullable|string',
            'prijs' => 'nullable|numeric',
            'km_stand' => 'nullable|integer',
            'status' => 'required|in:beschikbaar,concept,verkocht',
            'replace_fotos' => 'nullable|boolean',
            'fotos' => 'required_if:replace_fotos,1|array|min:1',
            'fotos.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ]);

        $existingAuto = Auto::where('kenteken', $request->input('kenteken'))
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $auto->id)
            ->where('status', '!=', Auto_status::VERKOCHT)
            ->first();

        if ($existingAuto) {
            throw new UnprocessableEntityHttpException('Er bestaat al een auto met dit kenteken en gebruiker, die niet verkocht is.');
        }
    }
}