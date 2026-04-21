<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amostra;
use App\Http\Resources\AmostraResource;
use App\Http\Requests\StoreAmostraRequest;
use App\Services\AmostraService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class AmostraController extends Controller
{
    protected AmostraService $service;

    public function __construct(AmostraService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $amostras = Amostra::query()
            ->porMaterial($request->query('material'))
            ->porStatus($request->query('status'))
            ->latest()
            ->paginate(10);

        return AmostraResource::collection($amostras);
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

    public function destroy(Amostra $amostra): JsonResponse
    {
        $amostra->delete();

        return response()->json([
            'status' => 'sucesso',
            'message' => 'Amostra removida logicamente (Soft Delete).',
            'uuid' => $amostra->id
        ], 200);
    }
}