<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $orders = $this->orderService->getAll($filters);
        return $this->successResponse($orders);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|string|in:pendente,confirmado,enviado,entregue,cancelado',
        ]);

        try {
            $this->orderService->updateStatus($id, $data['status']);
            return $this->successResponse(null, 'Status do pedido atualizado.');
        } catch (\Exception $e) {
            return $this->errorResponse('Erro: ' . $e->getMessage(), [], 422);
        }
    }
}
