<?php

namespace App\Services\Store;

use App\Contracts\ProductRepositoryInterface;
use App\Services\BaseService;

class ProductService extends BaseService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts(array $filters)
    {
        return $this->productRepository->getStoreProducts($filters);
    }

    public function getProductBySlug(string $slug)
    {
        return $this->productRepository->findBySlug($slug);
    }
}
