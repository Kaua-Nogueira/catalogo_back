<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\App;
use App\Services\TenantContext;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @var TenantContext $tenantContext */
        $tenantContext = App::make(TenantContext::class);

        if ($tenantContext->hasCompany()) {
            $builder->where($model->getTable() . '.company_id', $tenantContext->getCompanyId());
        }
    }
}
