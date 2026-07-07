<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Store\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ConfigController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(): JsonResponse
    {
        $config = $this->companyService->getCurrentCompanyConfig();
        return $this->successResponse($config);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'tagline' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'pix_key' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|string',
        ]);

        if ($request->filled('logo') && str_starts_with($request->input('logo'), 'data:image')) {
            $base64 = $request->input('logo');
            $extension = explode('/', explode(':', substr($base64, 0, strpos($base64, ';')))[1])[1];
            $replace = substr($base64, 0, strpos($base64, ',') + 1);
            $image = str_replace($replace, '', $base64);
            $image = str_replace(' ', '+', $image);
            $imageName = 'logo_' . time() . '.' . $extension;

            \Storage::disk('public')->put('logos/' . $imageName, base64_decode($image));
            $data['logo'] = '/storage/logos/' . $imageName;
        }

        $config = $this->companyService->getCurrentCompanyConfig();
        $config->update($data);

        return $this->successResponse($config, 'Configurações atualizadas.');
    }
}
