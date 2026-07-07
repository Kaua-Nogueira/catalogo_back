<?php

namespace App\Contracts;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    public function findByDomainOrSlug(string $domainOrSlug);
}
