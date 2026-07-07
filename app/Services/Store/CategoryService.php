<?php

namespace App\Services\Store;

use App\Contracts\CategoryRepositoryInterface;
use App\Services\BaseService;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllActive()
    {
        // Could filter by active status if the model had one,
        // for now just returns all for the current tenant via Global Scope
        return $this->categoryRepository->all();
    }
}
