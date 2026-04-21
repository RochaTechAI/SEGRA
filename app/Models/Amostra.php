<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Amostra extends Model
{
    use HasFactory, SoftDeletes;

    // Configuração para UUID como chave primária
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
     * Define a busca automática por UUID nas rotas.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Scopes de filtragem
    public function scopePorMaterial($query, $material)
    {
        if ($material) {
            return $query->where('tipo_material', strtolower($material));
        }
    }

    public function scopePorStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', strtolower($status));
        }
    }
}