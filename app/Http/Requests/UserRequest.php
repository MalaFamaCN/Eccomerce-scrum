<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   //comprueba si tiene un determinado rol o permiso
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
            //reglas globales para users
            'name' => 'required|string|regex:/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ\s]+$/',
            'apellido' => 'required|string|regex:/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ\s]+$/',
            'telefono' => 'required|numeric',
            'rol_id' => 'required', //es obligatorio que seleccione una opc que no sea 'seleccione un rol'    
        ];

        if ($this->isMethod('post')) { //para el método store
            $rules['dni'] = 'required|numeric|unique:users,dni';
            $rules['email'] = 'required|email|regex:/@.*\./|unique:users,email';
            $rules['password'] = 'required|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@#$%^&*()_+-]{6,}$/|confirmed';
        } else if ($this->isMethod('put')) { //para el método update
            $userId = $this->route('user');
            $rules['email'] = [
                'required',
                'email',
                'regex:/@.*\./',
                Rule::unique('users')->ignore($userId),
            ];
            $rules['password'] = 'nullable|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@#$%^&*()_+-]{6,}$/|confirmed';
        }

        return $rules;

    }

    public function messages(): array
    {
        // Definir mensajes de error personalizados
        return [
            'name.required' => 'Debe ingresar los nombres del usuario.',
            'name.regex' => 'Ingrese el nombre sin números ni signos.',

            'apellido.required' => 'Debe ingresar el apellido del usuario',
            'apellido.regex' => 'Ingrese el apellido sin números ni signos.',

            'telefono.required' => 'Debe ingresar el teléfono del usuario.',
            'telefono.numeric' => 'Ingrese el teléfono sin signos ni espacios',

            'rol_id.required' => 'Por favor seleccione un rol para el usuario.',

            'dni.required' => 'Debe ingresar el DNI del usuario.',
            'dni.unique' => 'Este número de DNI ya está en uso.',

            'email.required' => 'Debe ingresar el correo electrónico del usuario.',
            'email.email' => 'El correo ingresado no es válido o no es un correo.',
            'email.unique' => 'Este correo electrónico ya está en uso.',

            'password.required' => 'Debe ingresar una contraseña para el usuario.',
            'password.min' => 'La contraseña debe tener al menos 6 carácteres alfanuméricos.',
            'password.regex' => 'La contraseña debe ser alfanumérica.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
};
