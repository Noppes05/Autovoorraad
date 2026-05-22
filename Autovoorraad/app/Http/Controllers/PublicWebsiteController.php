<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicWebsiteController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->attributes->get('tenant');
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }
        $user = $this->validTenantInfo($tenant);
        return view('public_website.index', ['tenant' => $user]);
    }

    public function detail(Request $request, $tenantId, $publicId)
    {
        $tenant = $request->attributes->get('tenant');
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }
        $user = $this->validTenantInfo($tenant);
        return view('public_website.detail', ['tenant' => $user, 'carPublicId' => $publicId]);
    }

    private function validTenantInfo($tenant)
    {
        $tenant = $tenant['tenant'];
        return (object)[
            'id' => $tenant->public_id,
            'logo' => $tenant->logo,
            'email' => $tenant->email,
            'telefoonnummer' => $tenant->telefoonnummer,
            'herofoto' => $tenant->hero_foto,
            'hero_beschrijving' => $tenant->hero_beschrijving,
            'plaats' => $tenant->plaats,
            'adres' => $tenant->adres,
            'postcode' => $tenant->postcode,
            'naam'=> $tenant->name,
            'kleur' => $tenant->kleur,
        ];
    }
}
