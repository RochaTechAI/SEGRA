<?php

namespace App\Services;

use App\Models\Amostra;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Service responsavel pela orquestracao da logica de negocio.
 * Centraliza regras de LGPD e transacionalidade de dados.
 */
class AmostraService
{
    public function registrarAmostra(array $data): Amostra
    {
        return DB::transaction(function () use ($data) {
            try {
                /**
                 * LGPD Compliance:
                 * Anonimizacao do identificador do paciente via SHA-256.
                 */
                $hashPaciente = hash('sha256', $data['paciente_id']);

                return Amostra::create([
                    'hash_paciente'  => $hashPaciente,
                    'codigo_externo' => $data['codigo_externo'],
                    'tipo_material'  => $data['tipo_material'] ?? 'nao_informado',
                    'status'         => 'coletada',
                    'data_coleta'    => $data['data_coleta'] ?? now(),
                ]);

            } catch (Exception $e) {
                Log::error("FALHA_REGISTRO_AMOSTRA: " . $e->getMessage());
                throw new Exception("Erro interno ao processar registro cientifico.");
            }
        });
    }
}