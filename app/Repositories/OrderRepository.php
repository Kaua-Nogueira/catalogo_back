<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->with(['items.product.images'])->latest()->get($columns);
    }

    public function find(int $id, array $columns = ['*']): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->model->with(['items.product.images'])->find($id, $columns);
    }
}
