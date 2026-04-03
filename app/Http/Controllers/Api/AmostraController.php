<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amostra;
use App\Http\Resources\AmostraResource;
use App\Http\Requests\StoreAmostraRequest;
use App\Services\AmostraService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class AmostraController extends Controller
{
    protected AmostraService $service;

    public function __construct(AmostraService $service)
    {
        $this->service = $service;
    }

    public function index(): AnonymousResourceCollection
    {
        return AmostraResource::collection(Amostra::latest()->get());
    }

    public function store(StoreAmostraRequest $request): JsonResponse
    {
        $amostra = $this->service->registrarAmostra($request->validated());

        return (new AmostraResource($amostra))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Amostra $amostra): AmostraResource
    {
        return new AmostraResource($amostra);
    }
}