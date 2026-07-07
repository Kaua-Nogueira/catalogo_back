<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TenantContext;
use App\Models\Company;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantContext = app(TenantContext::class);

        // If the request is for admin panel, use the logged-in user's company_id
        if ($request->is('api/v1/admin/*') && auth('sanctum')->check()) {
            $tenantContext->setCompanyId(auth('sanctum')->user()->company_id);
            return $next($request);
        }

        // If not authenticated, check for tenant header (e.g. from storefront)
        $tenantId = $request->header('X-Tenant-ID');
        if ($tenantId) {
            $tenantContext->setCompanyId((int) $tenantId);
            return $next($request);
        }
        
        $tenantDomain = $request->header('X-Tenant-Domain');
        if ($tenantDomain) {
            $company = Company::where('domain', $tenantDomain)->orWhere('slug', $tenantDomain)->first();
            if ($company) {
                $tenantContext->setCompanyId($company->id);
                return $next($request);
            }
        }

        // Fallback to Company 1 (Kaua lojas) if no tenant is set
        if (!$tenantContext->hasCompany()) {
            $tenantContext->setCompanyId(1);
        }
        
        return $next($request);
    }
}
