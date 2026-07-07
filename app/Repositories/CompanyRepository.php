<?php

namespace App\Repositories;

use App\Contracts\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }

    public function findByDomainOrSlug(string $domainOrSlug)
    {
        return $this->model
            ->where('domain', $domainOrSlug)
            ->orWhere('slug', $domainOrSlug)
            ->first();
    }
}
