<?php

namespace App\Services;

use App\Models\Amostra;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AmostraService
{
    /**
     * Registra uma nova amostra no sistema com rigor de auditoria e transação atômica.
     */
    public function registrarAmostra(array $dados): Amostra
    {
        return DB::transaction(function () use ($dados) {
            // 1. Persistência da Amostra com padronização Enterprise (Fluent String)
            $amostra = Amostra::create([
                'codigo_externo' => $dados['identificador'],
                'tipo_material'  => str()->lower($dados['material']),
                'status'         => str()->lower($dados['status_amostra']),
                'data_coleta'    => $dados['data_coleta'],
                'hash_paciente'  => $dados['hash_paciente'], 
            ]);

            // 2. Registro de Auditoria
            Log::info("SEGRA-AUDIT: Amostra registrada", [
                'uuid'           => $amostra->id,
                'codigo_externo' => $amostra->codigo_externo,
                'operador_id'    => Auth::id() ?? 'sistema_automático', 
                'timestamp'      => now()->toIso8601String()
            ]);

            return $amostra;
        });
    }

    /**
     * Atualiza o status da amostra garantindo a integridade da linha do tempo.
     */
    public function atualizarStatus(Amostra $amostra, string $novoStatus): Amostra
    {
        return DB::transaction(function () use ($amostra, $novoStatus) {
            $statusAntigo = $amostra->status;
            
            $amostra->update([
                'status' => str()->lower($novoStatus)
            ]);

            // Log de Rastreabilidade (Tracking)
            Log::notice("SEGRA-TRACKING: Alteração de status", [
                'uuid'        => $amostra->id,
                'status_de'   => $statusAntigo,
                'status_para' => str()->lower($novoStatus),
                'operador_id' => Auth::id() ?? 'sistema_automático',
                'data'        => now()->toIso8601String()
            ]);

            return $amostra;
        });
    }
}