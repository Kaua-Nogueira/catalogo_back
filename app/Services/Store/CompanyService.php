<?php

namespace App\Services\Store;

use App\Contracts\CompanyRepositoryInterface;
use App\Services\BaseService;
use App\Services\TenantContext;

class CompanyService extends BaseService
{
    protected $companyRepository;
    protected $tenantContext;

    public function __construct(CompanyRepositoryInterface $companyRepository, TenantContext $tenantContext)
    {
        $this->companyRepository = $companyRepository;
        $this->tenantContext = $tenantContext;
    }

    public function getCurrentCompanyConfig()
    {
        $companyId = $this->tenantContext->getCompanyId();
        
        if (!$companyId) {
            return null;
        }

        return $this->companyRepository->find($companyId);
    }
}
