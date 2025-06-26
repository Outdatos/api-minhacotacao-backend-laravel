<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaixaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'min_qtd' => [
                'required',
                'integer',
                'min:1',
                'unique:faixas_quantidade,min_qtd,NULL,id,empresa_id,' . auth()->user()->empresa_id
            ],
            'max_qtd' => [
                'required',
                'integer',
                'gt:min_qtd',
                'unique:faixas_quantidade,max_qtd,NULL,id,empresa_id,' . auth()->user()->empresa_id
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'min_qtd.required' => 'O campo quantidade mínima é obrigatório.',
            'min_qtd.integer' => 'O valor deve ser um número inteiro.',
            'min_qtd.min' => 'O valor mínimo permitido é 1.',

            'max_qtd.required' => 'O campo quantidade máxima é obrigatório.',
            'max_qtd.integer' => 'O valor deve ser um número inteiro.',
            'max_qtd.gt' => 'A quantidade máxima deve ser superior à mínima.',

            'min_qtd.unique' => 'Já existe uma faixa com essa quantidade mínima.',
            'max_qtd.unique' => 'Já existe uma faixa com essa quantidade máxima.',
        ];
    }
}
