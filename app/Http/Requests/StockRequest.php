<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            //reglas globales para productos
            'codigo_producto' => 'required|max:15',
            'nombre' => 'required|max:120',
            'id_proveedor' => 'required',
            'id_marca' => 'required',
            'stock_deseado' => 'nullable|numeric',
            'stock_minimo' => 'nullable|numeric',
        ];
    
        if ($this->isMethod('post')) { // para el método store
            
            $rules['stock_disponible'] = [
                'required',
                'integer',
                'min:0',
            ];

        } else if ($this->isMethod('put')) { // para el método update

            $rules['motivo_modif'] = [
                'nullable',
                'max:200'
            ];

            $rules['tipo_modif'] = 'nullable'; // puede serlo porque permite que no haya cambios en modif si solo se desea alterar stock des y min

            $rules['stock_disponible'] = [
                'numeric',
                'integer',
                'min:0'
            ];

            $rules['cantidad_modif'] = [
                'nullable',
                'integer',
                'min:1'
            ];
            
        }
    
        return $rules;
    }

    public function attributes()
    {   // Renombramiento de los campos
        return [
            'codigo_producto' => 'código',
            'nombre' => 'nombre',
            'id_proveedor' => 'proveedor',
            'id_categoria' => 'categoría',
            'id_marca' => 'marca',
            'stock_deseado' => 'stock deseado',
            'stock_minimo' => 'stock minimo',
            'stock_disponible' => 'stock disponible',
            'cantidad_modif' => 'cantidad modificada',
        ];
    }

    public function messages(): array
    {
        // Definir mensajes de error personalizados
        return [
            'url_imagen.required' => 'Debe cargar almenos una imagen para este producto.',
            'url_imagen.max' => 'Solo se permite cargar 3 imágenes como máximo.',
            'descripcion' => 'La descripción del producto no puede estar vacía',
        ];
    }

}
