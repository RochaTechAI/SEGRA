<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AmostraService;
use Exception;

class ImportarAmostras extends Command
{
    /**
     * Assinatura do comando via terminal: php artisan segra:import
     */
    protected $signature = 'segra:import';

    protected $description = 'Processamento em lote de amostras para o sistema SEGRA';

    /**
     * Injeta a instancia de AmostraService via Dependency Injection.
     */
    public function handle(AmostraService $service)
    {
        $this->info('SEGRA: Iniciando carga de lote enterprise...');

        // Simulacao de um dataset recebido via integração externa
        $lote = [
            [
                'paciente_id'    => 'ID-PAC-01-2026', 
                'codigo_externo' => 'EXT-REQ-001', 
                'tipo_material'  => 'sangue'
            ],
            [
                'paciente_id'    => 'ID-PAC-02-2026', 
                'codigo_externo' => 'EXT-REQ-002', 
                'tipo_material'  => 'plasma'
            ],
            [
                'paciente_id'    => 'ID-PAC-03-2026', 
                'codigo_externo' => 'EXT-REQ-003', 
                'tipo_material'  => 'dna'
            ],
        ];

        $sucessoCount = 0;
        $falhaCount = 0;

        foreach ($lote as $item) {
            try {
                // O Command atua apenas como orquestrador, delegando a logica ao Service.
                $service->registrarAmostra($item);
                $this->line("[OK] Amostra {$item['codigo_externo']} processada.");
                $sucessoCount++;
            } catch (Exception $e) {
                $this->error("[ERRO] Falha na amostra {$item['codigo_externo']}: " . $e->getMessage());
                $falhaCount++;
            }
        }

        $this->newLine();
        $this->info("Relatorio de Importacao:");
        $this->info("- Sucesso: $sucessoCount");
        $this->info("- Falhas: $falhaCount");
    }
}