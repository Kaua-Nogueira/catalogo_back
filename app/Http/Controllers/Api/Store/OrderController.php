<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CheckoutRequest;
use App\Services\Store\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(CheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());
            return $this->successResponse($order, 'Pedido criado com sucesso!', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Erro ao criar pedido: ' . $e->getMessage(), [], 422);
        }
    }

    public function track(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return $this->successResponse([]);
        }

        // Convert query string format e.g. "1,2,3" or array
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $orders = \App\Models\Order::with(['items.product.images'])
            ->whereIn('id', $ids)
            ->latest()
            ->get();

        return $this->successResponse($orders);
    }

    public function show($id): JsonResponse
    {
        $order = \App\Models\Order::with(['items.product.images'])->find($id);

        if (!$order) {
            return $this->errorResponse('Pedido não encontrado.', [], 404);
        }

        return $this->successResponse($order);
    }
}
