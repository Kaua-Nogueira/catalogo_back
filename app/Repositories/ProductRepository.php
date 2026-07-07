<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getStoreProducts(array $filters)
    {
        $query = $this->model->with(['category', 'images'])->where('available', true);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'recent':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->with(['category', 'images'])->where('slug', $slug)->where('available', true)->first();
    }
}
