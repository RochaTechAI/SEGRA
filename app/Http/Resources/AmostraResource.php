<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmostraResource extends JsonResource
{
    /**
     * Transforma o recurso em um array.
     * Padronizado para o SEGRA com suporte a Timeline de Rastreabilidade.
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'           => $this->id,
            'identificador'  => $this->codigo_externo,
            'material'       => str()->upper($this->tipo_material),
            'status_amostra' => $this->status,
            'data_coleta'    => $this->data_coleta->toIso8601String(),
            
            // Inclusão da Timeline (Só aparece se você usar ->load('movimentacoes') na Controller)
            'historico'      => MovimentacaoResource::collection($this->whenLoaded('movimentacoes')),

            'metadados'      => [
                'lgpd_hash'     => $this->hash_paciente,
                'criado_em'     => $this->created_at->toIso8601String(),
                'atualizado_em' => $this->updated_at->toIso8601String(),
            ],

            'links' => [
                'self' => route('amostras.show', $this->id),
            ]
        ];
    }
}