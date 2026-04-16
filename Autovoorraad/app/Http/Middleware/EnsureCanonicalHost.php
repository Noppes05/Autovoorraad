<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanonicalHost
{
    /**
     * Force requests onto the configured APP_URL host (or its tenant subdomains)
     * so session and CSRF cookies are always issued for one domain tree.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        if (! is_string($appHost) || $appHost === '') {
            return $next($request);
        }

        $requestHost = strtolower($request->getHost());
        $canonicalHost = strtolower($appHost);

        $isCanonicalHost = $requestHost === $canonicalHost;
        $isTenantSubdomain = str_ends_with($requestHost, '.'.$canonicalHost);

        if ($isCanonicalHost || $isTenantSubdomain) {
            return $next($request);
        }

        $targetUrl = $request->getScheme().'://'.$canonicalHost.$request->getRequestUri();

        return redirect()->to($targetUrl, 302);
    }
}
