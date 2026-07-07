<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->categoryService->getAll());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $category = $this->categoryService->create($data);
        return $this->successResponse($category, 'Categoria criada.', 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $this->categoryService->update($id, $data);
        return $this->successResponse(null, 'Categoria atualizada.');
    }

    public function destroy($id): JsonResponse
    {
        $this->categoryService->delete($id);
        return $this->successResponse(null, 'Categoria removida.');
    }
}
