<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validacao enterprise para entrada de novas amostras.
 * Garante que os tipos de materiais e formatos de dados estejam corretos.
 */
class StoreAmostraRequest extends FormRequest
{
    /**
     * Determina se o usuario tem permissao para esta acao.
     */
    public function authorize(): bool
    {
        return true; // No futuro, implementar verificacao de permissao aqui
    }

    /**
     * Regras de validacao estritas.
     */
    public function rules(): array
    {
        return [
            'paciente_id'    => 'required|string|min:3',
            'codigo_externo' => 'required|string|unique:amostras,codigo_externo',
            'tipo_material'  => 'required|string|in:sangue,plasma,dna,urina',
            'data_coleta'    => 'nullable|date_format:Y-m-d H:i:s'
        ];
    }
}