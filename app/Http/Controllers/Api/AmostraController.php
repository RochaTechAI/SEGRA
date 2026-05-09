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

/**
 * Controller responsável pelo gerenciamento de Amostras Biológicas.
 * Focado em integridade de dados e rastreabilidade (Timeline).
 */
class AmostraController extends Controller
{
    protected AmostraService $service;

    public function __construct(AmostraService $service)
    {
        $this->service = $service;
    }

    /**
     * Listagem paginada de amostras com filtros dinâmicos.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $amostras = Amostra::query()
            ->porMaterial($request->query('material'))
            ->porStatus($request->query('status'))
            ->latest()
            ->paginate(15);

        return AmostraResource::collection($amostras);
    }

    /**
     * Registro de nova amostra.
     * Utiliza o Service Layer para garantir a transação e o rastro inicial.
     */
    public function store(StoreAmostraRequest $request): JsonResponse
    {
        $amostra = $this->service->registrarAmostra($request->validated());

        return (new AmostraResource($amostra))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Exibe detalhes de uma amostra específica com seu histórico completo (Eager Loading).
     */
    public function show(Amostra $amostra): AmostraResource
    {
        return new AmostraResource($amostra->load('movimentacoes.usuario'));
    }

    /**
     * Atualiza o status da amostra e gera rastro automático na timeline.
     * Retorna a amostra com o novo histórico carregado.
     */
    public function update(Request $request, Amostra $amostra): AmostraResource
    {
        $request->validate([
            'status'     => 'required|string|max:50',
            'observacao' => 'nullable|string|max:255'
        ]);

        // O Service coordena a atualização e a persistência do rastro
        $this->service->atualizarStatus(
            $amostra, 
            $request->status, 
            $request->observacao
        );

        // Retornamos a amostra recarregando as movimentações para o Postman exibir o rastro novo
        return new AmostraResource($amostra->load('movimentacoes.usuario'));
    }

    /**
     * Remoção lógica (Soft Delete).
     * Preserva os dados no banco para auditoria, mas remove da listagem ativa.
     */
    public function destroy(Amostra $amostra): JsonResponse
    {
        $amostra->delete();

        return response()->json([
            'status'  => 'sucesso',
            'message' => 'Amostra removida logicamente (Soft Delete).',
            'uuid'    => $amostra->id
        ], 200);
    }
}