<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAmostraRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true; // Alteraremos quando implementarmos o Sanctum
    }

    /**
     * Regras de validação para a criação de amostras.
     */
    public function rules(): array
    {
        return [
            'identificador'  => ['required', 'string', 'unique:amostras,codigo_externo'],
            'material'       => ['required', 'string', Rule::in(['sangue', 'plasma', 'dna', 'urina'])],
            'status_amostra' => ['required', 'string', Rule::in(['coletada', 'em_transito', 'recebida', 'em_analise', 'finalizada'])],
            'data_coleta'    => ['required', 'date', 'before_or_equal:now'],
            'hash_paciente'  => ['required', 'string', 'size:64'], // Simulando um SHA-256 para LGPD
        ];
    }

    /**
     * Mensagens customizadas para o ambiente Enterprise.
     */
    public function messages(): array
    {
        return [
            'material.in' => 'O material fornecido não é suportado pelo protocolo SEGRA.',
            'status_amostra.in' => 'O status informado é inválido para o fluxo de trabalho.',
            'data_coleta.before_or_equal' => 'A data de coleta não pode estar no futuro.',
        ];
    }
}