<?php

namespace App\Actions;

use App\Models\Auto;
use App\Models\AutoFoto;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncAutoFotos
{
    use AsAction;

    public function handle(Auto $auto, array $fotos = [], bool $replace = true): void
    {
        $startOrder = 1;

        if ($replace) {
            $this->deleteFotos($auto);
        } else {
            $startOrder = ((int) AutoFoto::where('auto_id', $auto->id)->max('volgorde_nummer')) + 1;
        }

        if (empty($fotos)) {
            return;
        }

        $this->storeFotos($auto, $fotos, $startOrder);
    }

    private function storeFotos(Auto $auto, array $fotos, int $startOrder = 1): void
    {
        $volgorde = $startOrder;

        foreach ($fotos as $foto) {
            $path = $foto->store('uploads', 'public');

            AutoFoto::create([
                'auto_id' => $auto->id,
                'foto_path' => $path,
                'volgorde_nummer' => $volgorde,
            ]);

            $volgorde++;
        }
    }

    private function deleteFotos(Auto $auto): void
    {
        $autoFotos = AutoFoto::where('auto_id', $auto->id)->get();

        foreach ($autoFotos as $foto) {
            Storage::disk('public')->delete($foto->foto_path);
            $foto->delete();
        }
    }
}