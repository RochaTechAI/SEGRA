<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Amostra extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Configuracao para utilizacao de UUID como chave primaria.
     * Impede a enumeracao de registros por IDs sequenciais.
     */
    protected $keyType = 'string';
    public $incrementing = false;

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
     * Boot function para atribuicao automatica de UUID v4.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}