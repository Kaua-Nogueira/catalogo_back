<?php

namespace App\Models\Traits;

use App\Models\Company;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCompany
{
    /**
     * Boot the BelongsToCompany trait for a model.
     */
    protected static function bootBelongsToCompany(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            $tenantContext = app(\App\Services\TenantContext::class);
            if ($tenantContext->hasCompany() && !$model->company_id) {
                $model->company_id = $tenantContext->getCompanyId();
            }
        });
    }

    /**
     * Get the company that owns the model.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
