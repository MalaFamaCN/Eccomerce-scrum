<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Pedido;

class PedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
    
        $rules = [
            'nombre' => 'required|string|min:3|max:30',
            'apellido' => 'required|string|min:3|max:30',
            'dni' => 'required|numeric|min:0|max:999999999',
            'email' => 'required|email|regex:/@.*\./',
            'direccion' => 'required|string|min:3|max:40',
            'codigo_postal' => 'required|numeric|min:0|max:999999',
            'telefono' => 'required|numeric|min:0|max:99999999999'
        ];
    
        return $rules;
    }
    public function messages(): array
    {
        // Definir mensajes de error personalizados
        return [
            
        ];
    }
}
