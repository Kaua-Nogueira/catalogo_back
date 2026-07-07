<?php

namespace App\Services;

class TenantContext
{
    protected ?int $companyId = null;

    public function setCompanyId(?int $companyId): void
    {
        $this->companyId = $companyId;
    }

    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    public function hasCompany(): bool
    {
        return $this->companyId !== null;
    }
}
