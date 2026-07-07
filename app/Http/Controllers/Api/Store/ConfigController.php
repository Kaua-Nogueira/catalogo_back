<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Services\Store\CompanyService;
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

        if (!$config) {
            return $this->errorResponse('Configurações não encontradas ou tenant não especificado.', [], 404);
        }

        return $this->successResponse($config);
    }
}
