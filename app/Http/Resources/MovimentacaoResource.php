<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimentacaoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status_anterior' => $this->status_anterior,
            'status_novo' => $this->status_novo,
            'observacao' => $this->observacao,
            'realizado_por' => $this->usuario->name ?? 'Sistema Automático',
            'data' => $this->created_at->toIso8601String(),
        ];
    }
}