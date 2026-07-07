<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['category_id', 'search', 'sort', 'per_page']);
        $products = $this->productService->getAll($filters);
        
        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'available' => 'boolean',
            'stock' => 'required|integer|min:0',
            'badges' => 'nullable|array',
            'images' => 'nullable|array',
        ]);

        $product = $this->productService->create($data);

        if (!empty($data['images'])) {
            foreach ($data['images'] as $index => $base64Image) {
                if (str_starts_with($base64Image, 'data:image')) {
                    @list($type, $file_data) = explode(';', $base64Image);
                    @list(, $file_data)      = explode(',', $file_data);
                    $imageName = 'product_' . $product->id . '_' . time() . '_' . $index . '.png';
                    \Illuminate\Support\Facades\Storage::disk('public')->put('products/' . $imageName, base64_decode($file_data));
                    
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'path' => '/storage/products/' . $imageName,
                        'order' => $index
                    ]);
                } else {
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $base64Image,
                        'order' => $index
                    ]);
                }
            }
        }
        return $this->successResponse($product, 'Produto criado.', 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'available' => 'boolean',
            'stock' => 'required|integer|min:0',
            'badges' => 'nullable|array',
        ]);

        $this->productService->update($id, $data);
        return $this->successResponse(null, 'Produto atualizado.');
    }

    public function destroy($id): JsonResponse
    {
        $this->productService->delete($id);
        return $this->successResponse(null, 'Produto removido.');
    }
}
