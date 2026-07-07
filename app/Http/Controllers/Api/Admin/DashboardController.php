<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        // Mocked dashboard data for now, as real analytics requires more tables and queries
        $salesSeries = [
            ['month' => 'Jan', 'pedidos' => 24, 'faturamento' => 12400],
            ['month' => 'Fev', 'pedidos' => 31, 'faturamento' => 15200],
            ['month' => 'Mar', 'pedidos' => 28, 'faturamento' => 14100],
            ['month' => 'Abr', 'pedidos' => 42, 'faturamento' => 21800],
            ['month' => 'Mai', 'pedidos' => 38, 'faturamento' => 19900],
            ['month' => 'Jun', 'pedidos' => 51, 'faturamento' => 27600],
            ['month' => 'Jul', 'pedidos' => 45, 'faturamento' => 24300],
        ];

        $productsCount = \App\Models\Product::count();
        $categoriesCount = \App\Models\Category::count();
        $ordersCount = \App\Models\Order::count();
        $faturamento = \App\Models\Order::whereIn('status', ['confirmado', 'enviado', 'entregue'])->sum('total');
        $recentOrders = \App\Models\Order::latest()->take(5)->get();

        return $this->successResponse([
            'salesSeries' => $salesSeries,
            'productsCount' => $productsCount,
            'categoriesCount' => $categoriesCount,
            'ordersCount' => $ordersCount,
            'faturamento' => $faturamento,
            'recentOrders' => $recentOrders,
        ]);
    }
}
