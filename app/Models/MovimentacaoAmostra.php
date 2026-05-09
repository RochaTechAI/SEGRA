<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoAmostra extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao Model.
     * O Laravel tentaria "movimentacao_amostras", mas é sempre bom explicitar.
     */
    protected $table = 'movimentacao_amostras';

    /**
     * Atributos que podem ser preenchidos em massa.
     * Sem isso, o método create() no Service não funciona.
     */
    protected $fillable = [
        'amostra_id',
        'status_anterior',
        'status_novo',
        'user_id',
        'observacao'
    ];

    /**
     * Relacionamento: Uma movimentação pertence a uma única amostra.
     */
    public function amostra(): BelongsTo
    {
        return $this->belongsTo(Amostra::class, 'amostra_id');
    }

    /**
     * Relacionamento: Uma movimentação foi realizada por um usuário (operador).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}