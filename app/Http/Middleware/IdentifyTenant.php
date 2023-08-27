<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $this->getTenantFromRequest($request);

        if ($tenant) {
            config(['database.connections.tenant.database' => 'tenant_' . $tenant]);
        }


        return $next($request);
    }


    private function getTenantFromRequest($request)
    {
        $subdomain = explode('.', $request->getHost())[0]; // Extract subdomain
        $request->attributes->add(['tenant' => $subdomain]);

        return $subdomain;
    }


}
