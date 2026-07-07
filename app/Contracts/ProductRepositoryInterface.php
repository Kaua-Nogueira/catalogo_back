<?php

namespace App\Contracts;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getStoreProducts(array $filters);
    public function findBySlug(string $slug);
}
