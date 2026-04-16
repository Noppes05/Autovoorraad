<?php

namespace App\Actions;

use Jdkweb\RdwApi\Controllers\RdwApiRequest;
use Jdkweb\RdwApi\Enums\Endpoints;
use Lorisleiva\Actions\Concerns\AsAction;

class FetchRdw
{
    use AsAction;

    public function handle(string $kenteken)
    {
        $vehicleData = RdwApiRequest::make()
        ->setLicenseplate($kenteken)->setLanguage('nl')
        ->setEndpoints([Endpoints::VEHICLE])
        ->fetch();

        $vehicleData = $this->formatVehicleData($vehicleData->response['Voertuigen'] ?? null);
        return $vehicleData;
    }

      protected function formatVehicleData(array $data): array
    {
        return [
            'kenteken' => $data['kenteken'] ?? null,
            'merk' => $data['merk'] ?? null,
            'model' => $data['handelsbenaming'] ?? null,
            'bouwjaar' => $this->extractBouwjaar($data['datum_eerste_tenaamstelling_in_nederland']) ?? null,
            'kilometer_stand' => $data['kilometerstand'] ?? null,
        ];
    }

       /**
     * Extract bouwjaar from registration date.
     */
    protected function extractBouwjaar(?string $date): ?string
    {
        if (! $date) {
            return null;
        }

        // RDW dates are in format YYYYMMDD or YYYY-MM-DD
        if (preg_match('/^(\d{4})/', $date, $matches)) {
            return $matches[1];
        }

        return $date;
    }
}
