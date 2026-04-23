<?php

namespace App\Http\Middleware;

use App\Actions\Search_tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubdomainTenantDetection
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $appUrlHost = parse_url(config('app.url'), PHP_URL_HOST);

        if ($host !== $appUrlHost) {
            $subdomain = str_replace('.' . $appUrlHost, '', $host);
            // You can set the tenant in the request or use a service container binding
            $user = Search_tenant::run($subdomain);
            if (isset($user['error'])) {
                abort(404, 'Tenant not found');
            }
            $request->attributes->set('tenant', $user);
        }

        return $next($request);
    }
}
