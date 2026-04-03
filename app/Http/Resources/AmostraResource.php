<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmostraResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid'           => $this->id,
            'identificador'  => $this->codigo_externo,
            'material'       => strtoupper($this->tipo_material),
            'status_amostra' => $this->status,
            'data_coleta'    => $this->data_coleta->toIso8601String(),
            'metadados'      => [
                'lgpd_hash'     => $this->hash_paciente,
                'processado_em' => $this->created_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}