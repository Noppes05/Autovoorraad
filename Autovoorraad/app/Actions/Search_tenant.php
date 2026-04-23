<?php

namespace App\Actions;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class Search_tenant
{
    use AsAction;

    public function handle(string $tenant)
    {
        $user = User::where('name', $tenant)->first();
        if (!$user) {
            return ['error' => 'Tenant not found'];
        }
        return ['tenant' => $user];
    }
}
