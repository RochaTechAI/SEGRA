<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as alteracoes no banco de dados.
     * Define a estrutura da tabela seguindo padroes de seguranca e LGPD.
     */
    public function up(): void
    {
        Schema::create('amostras', function (Blueprint $table) {
            // Definicao de UUID como chave primaria (Enterprise Standard)
            $table->uuid('id')->primary();
            
            // Hash do paciente para conformidade com a LGPD
            $table->string('hash_paciente')->index();
            
            // Identificador legivel para rastreabilidade laboratorial
            $table->string('codigo_externo')->unique();
            
            $table->string('tipo_material');
            $table->string('status')->default('coletada');
            $table->timestamp('data_coleta');
            
            // SoftDeletes para manter rastro de auditoria cientifica
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverte as alteracoes.
     */
    public function down(): void
    {
        Schema::dropIfExists('amostras');
    }
};