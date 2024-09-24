<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'url_imagen' => 'required|array|max:3',
            'url_imagen.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Verifica que cada elemento sea una imagen válida - Nota: el * indica que valida una matriz
            'codigo_producto' => 'required|max:15',
            'nombre' => 'required|max:120',
            'id_proveedor' => 'required',
            'id_categoria' => 'required',
            'id_marca' => 'required',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:1000',
            'stock_disponible' => 'nullable|numeric|min:0',
            'stock_deseado' => 'nullable|numeric|min:1',
            'stock_minimo' => 'nullable|numeric|min:1',
        ];
    
        if ($this->isMethod('post')) { // para el método store
            //$rules['descripcion'] = 'required|min:100|max:500|unique:proveedores';
        } else if ($this->isMethod('put')) { // para el método update
            $productoId = $this->route('producto');
            $rules['nombre'] = [
                'required',
                'max:80',
                Rule::unique('productos')->ignore($productoId),
            ];
            $rules['url_imagen'] = 'nullable|max:3';
            //$rules['url_imagen.*'] => 'image|mimes:jpeg,png,jpg,webp|max:2048';
        }
    
        return $rules;
    }

    public function attributes()
    {   // Renombramiento de los campos
        return [
            'url_imagen' => 'imagen',
            'codigo_producto' => 'código',
            'nombre' => 'nombre',
            'id_proveedor' => 'proveedor',
            'id_categoria' => 'categoría',
            'id_marca' => 'marca',
            'descripcion' => 'descripción',
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
