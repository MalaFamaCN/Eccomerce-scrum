<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            'razon_social' => 'required|min:3|max:30',
            'direccion' => 'required|min:3|max:40',
            'telefono' => 'required|min:3|max:20',
            'activo' => 'required|boolean'
        ];
    
        if ($this->isMethod('post')) { // para el método store
            $rules['descripcion'] = 'required|min:3|max:40|unique:proveedores';
            $rules['correo'] = 'required|email|max:30|unique:proveedores';
            $rules['cuit'] = 'required|min:13|max:14|regex:/^(?=.*\d)(?=.*-)[\d-]+$/|unique:proveedores,cuit';
        } else if ($this->isMethod('put')) { // para el método update
            $proveedorId = $this->route('proveedor');

            $rules['cuit'] = [
                'required',
                'min:13',
                'max:14',
                //'regex:/^\d{2}-\d+-\d+$/', //es obligatorio dos guiónes
                'regex:/^(?=.*\d)(?=.*-)[\d-]+$/', //es obligatorio dos guiónes y otro signo causará error
                Rule::unique('proveedores')->ignore($proveedorId),
            ];

        }
    
        return $rules;
    }

    public function attributes()
    {   // Renombramiento de los campos
        return [
            'descripcion' => 'nombre',
            'cuit' => 'CUIT',
            'razon_social' => 'razón social',
            'direccion' => 'dirección',
            'telefono' => 'teléfono',
        ];
    }

    public function messages(): array
    {
        // Definir mensajes de error personalizados
        return [
            'cuit.regex' => 'Ingrese un CUIT válido. Con el formato 99-99999999-9',
        ];
    }
}
