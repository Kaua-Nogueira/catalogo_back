<?php

namespace App\Services\Admin;

use App\Contracts\OrderRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAll(array $filters)
    {
        return $this->orderRepository->all();
    }

    public function updateStatus($id, string $status)
    {
        return DB::transaction(function () use ($id, $status) {
            $order = $this->orderRepository->find($id);
            if (!$order) {
                throw new \Exception("Pedido não encontrado.");
            }

            $oldStatus = $order->status;

            // Transition: From anything to CONFIRMADO -> Decrement stock
            if ($status === 'confirmado' && $oldStatus !== 'confirmado') {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if (!$product) {
                        throw new \Exception("Produto do item do pedido não encontrado ou excluído.");
                    }

                    if ($product->stock < $item->quantity) {
                        throw new \Exception("Estoque insuficiente para o produto: {$product->name} (Solicitado: {$item->quantity}, Disponível: {$product->stock})");
                    }
                }

                // If all products have enough stock, decrement
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Transition: From CONFIRMADO to anything else -> Increment stock back
            if ($status !== 'confirmado' && $oldStatus === 'confirmado') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            return $order->update(['status' => $status]);
        });
    }
}
