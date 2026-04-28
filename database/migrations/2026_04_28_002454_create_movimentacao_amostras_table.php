<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacao_amostras', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignUuid('amostra_id')->constrained('amostras')->onDelete('cascade');
            $blueprint->string('status_anterior')->nullable();
            $blueprint->string('status_novo');
            $blueprint->foreignId('user_id')->nullable()->constrained('users');
            $blueprint->text('observacao')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacao_amostras');
    }
};