<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RdwService
{
    /**
     * The base URL for the RDW Open Data API.
     */
    protected string $baseUrl = 'https://opendata.rdw.nl/resource/m9d7-ebf2.json';

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
                'kenteken' => "'{$kenteken}'",
            ]);

            if (!$response->successful()) {
                Log::error('RDW API request failed', [
                    'status' => $response->status(),
                    'kenteken' => $kenteken
                ]);
                return null;
            }

            $data = $response->json();
            // Check if we have data
            if (empty($data[0])) {
                return null;
            }

            return $this->formatVehicleData($data[0]);

        } catch (\Exception $e) {
            Log::error('RDW API exception', [
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
            'merk' => $this->extractMerk($data['merk'] ?? null),
            'model' => $data['handelsbenaming'] ?? null,
            'bouwjaar' => $this->extractBouwjaar($data['datum_eerste_tenaamstelling_in_nederland'] ?? null),
            'kilometer_stand' => $data['kilometerstand'] ?? null,
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
