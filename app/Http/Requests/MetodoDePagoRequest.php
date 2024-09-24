<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MetodoDePagoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //RECUERDA PONER ESTO EN TRUE!!!
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $rules = [
            'activo' => 'required|boolean'
        ];

        if ($this->isMethod('post')) { //para el método store
            $rules['descripcion'] = 'required|min:3|max:20|unique:metodos_de_pago,descripcion';
        } else if ($this->isMethod('put')) { //para el método update
            $mdpId = $this->route('metodosdepago'); //obtengo el id que está en la ruta
            
            $rules['descripcion'] = [
                'required',
                'min:3',
                'max:20',
                Rule::unique('metodos_de_pago')->ignore($mdpId), // uso el id de esta categoría para que ignore la regla
            ];
        }
        return $rules;
    }

    public function attributes()
    {   // Renombramiento de los campos
        return [
            'descripcion' => 'nombre',
        ];
    }

    public function messages(): array
    {
        // Definir mensajes de error personalizados
        return [
            'descripcion.unique' => 'Este método de pago ya existe.',
        ];
    }
}

// Comando para crear este request: php artisan make:request StoreMarca
// Luego en el controlador al request, instanciarlo como una clase de StoreMarca