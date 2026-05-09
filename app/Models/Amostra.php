<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Amostra extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Configuração para UUID como chave primária.
     * Necessário para garantir que o Laravel não trate o ID como inteiro.
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'hash_paciente',
        'codigo_externo',
        'tipo_material',
        'status',
        'data_coleta'
    ];

    protected $casts = [
        'data_coleta' => 'datetime',
    ];

    /**
     * Define a busca automática por UUID nas rotas da API.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Boot do Model para geração automática de UUID v4 no momento da criação.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * RELACIONAMENTO: Obtém todo o histórico de movimentações da amostra.
     * Essencial para a Timeline de Rastreabilidade do SEGRA.
     */
    public function movimentacoes(): HasMany
    {
        return $this->hasMany(MovimentacaoAmostra::class, 'amostra_id');
    }

    /**
     * SCOPE: Filtra amostras por tipo de material.
     */
    public function scopePorMaterial($query, $material)
    {
        if ($material) {
            return $query->where('tipo_material', str()->lower($material));
        }
    }

    /**
     * SCOPE: Filtra amostras por status atual.
     */
    public function scopePorStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', str()->lower($status));
        }
    }
}