<?php

namespace App\Services\Store;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Services\BaseService;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $productRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, ProductRepositoryInterface $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $total = 0;
            $orderItems = [];

            // Calculate total and prepare items
            foreach ($data['items'] as $item) {
                $product = $this->productRepository->find($item['productId']);
                
                if (!$product) {
                    throw new \Exception("Product not found: " . $item['productId']);
                }

                $price = $product->price;
                $total += $price * $item['quantity'];

                $orderItems[] = new OrderItem([
                    'product_id' => $product->id,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                ]);
            }

            // Create order
            $order = $this->orderRepository->create([
                'number' => '#' . mt_rand(1000, 9999), // simple generator
                'customer_name' => $data['customerName'],
                'phone' => $data['phone'],
                'address' => $data['address'] ?? null,
                'notes' => $data['notes'] ?? null,
                'total' => $total,
                'status' => 'pendente'
            ]);

            // Save items
            $order->items()->saveMany($orderItems);

            return $order->load('items.product.images');
        });
    }
}
