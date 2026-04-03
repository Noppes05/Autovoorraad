<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RdwService
{
    /**
     * The base URL for the RDW Open Data API.
     */
    protected string $baseUrl = 'https://opendata.rdw.nl/api/views/m9d7-ewf7/rows.json';

    /**
     * Fetch vehicle data from RDW API by license plate.
     *
     * @param string $kenteken
     * @return array|null
     */
    public function getVehicleData(string $kenteken): ?array
    {
        // Normalize kenteken: remove spaces and convert to uppercase
        $kenteken = strtoupper(str_replace(' ', '', $kenteken));

        // Validate kenteken format (Dutch format: XX-XX-XX or XXXXXX)
        if (!preg_match('/^[A-Z0-9]{6}$/', $kenteken)) {
            return null;
        }

        try {
            $response = Http::get($this->baseUrl, [
                'where' => "kenteken in ('{$kenteken}')",
                'opentable' => 'true'
            ]);

            if (!$response->successful()) {
                \Log::error('RDW API request failed', [
                    'status' => $response->status(),
                    'kenteken' => $kenteken
                ]);
                return null;
            }

            $data = $response->json();

            // Check if we have data
            if (empty($data['data']) || empty($data['data'][0])) {
                return null;
            }

            // The API returns an array of fields, we need to map them by column names
            $columns = array_column($data['columns'], 'name');
            $firstRow = $data['data'][0];

            // Combine column names with row data
            $vehicleData = array_combine($columns, $firstRow);

            return $this->formatVehicleData($vehicleData);

        } catch (\Exception $e) {
            \Log::error('RDW API exception', [
                'message' => $e->getMessage(),
                'kenteken' => $kenteken
            ]);
            return null;
        }
    }

    /**
     * Format the raw RDW data to a more usable structure.
     *
     * @param array $data
     * @return array
     */
    protected function formatVehicleData(array $data): array
    {
        return [
            'kenteken' => $data['kenteken'] ?? null,
            'merk' => $this->extractMerk($data['voertuigsoort'] ?? $data['merklijning'] ?? null),
            'model' => $data['handelsbenaming'] ?? null,
            'voertuigsoort' => $data['voertuigsoort'] ?? null,
            'bruto_bpm' => $data['bruto_bpm'] ?? null,
            'netto_bpm' => $data['netto_bpm'] ?? null,
            'europese_voertuigcategorie' => $data['europese_voertuigcategorie'] ?? null,
            'cbi_vervaldatum' => $data['cbi_vervaldatum'] ?? null,
            'eerst_registratie' => $data[' datum eerste registratie in nederland'] ?? $data['datum_eerste_registratie_nederland'] ?? null,
            'bouwjaar' => $this->extractBouwjaar($data[' datum eerste registratie in nederland'] ?? $data['datum_eerste_registratie_nederland'] ?? null),
            'kilometer_stand' => $data['kilometerstand'] ?? null,
            'brandstof' => $data['brandstof_omschrijving'] ?? $data['brandstof'] ?? null,
            'co2_uitstoot' => $data['co2_uitstoot_combined'] ?? $data['co2_uitstoot'] ?? null,
            'kleur' => $data['externe_kleur'] ?? null,
            'carrosserie' => $data['carrosserie'] ?? null,
            'inrichting' => $data['inrichting'] ?? null,
            ' massa_ledig_voertuig' => $data['massa_ledig_voertuig'] ?? null,
            'massa_rijklaar' => $data['massa_rijklaar'] ?? null,
            'maximum_massa_voertuig' => $data['maximum_massa_voertuig'] ?? null,
            'wacht_op_keuring' => $data['vervaldatum_apk'] ?? null,
            'apk_vervaldatum' => $data['vervaldatum_apk'] ?? null,
            'diesel_roetfilter' => $data['dieselroetfilter'] ?? null,
            'verzekering' => $data['verzekering'] ?? null,
        ];
    }

    /**
     * Extract merk from voertuigsoort or merklijning.
     *
     * @param string|null $value
     * @return string|null
     */
    protected function extractMerk(?string $value): ?string
    {
        // Try to extract brand from voertuigsoort like " Personenauto BMW "
        if ($value && preg_match('/\b([A-Z][a-z]+(?: [A-Z][a-z]+)*)\b/', $value, $matches)) {
            return trim($matches[1]);
        }

        // Or use the direct value
        return $value ? trim($value) : null;
    }

    /**
     * Extract bouwjaar from registration date.
     *
     * @param string|null $date
     * @return string|null
     */
    protected function extractBouwjaar(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        // RDW dates are in format YYYYMMDD or YYYY-MM-DD
        if (preg_match('/^(\d{4})/', $date, $matches)) {
            return $matches[1];
        }

        return $date;
    }
}
