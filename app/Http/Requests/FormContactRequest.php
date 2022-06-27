<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Queremos conocerte. Por favor ingresa tu nombre.',
            'email.required' => 'Dejanos una dirección de correo para poder estar en contacto contigo.',
            'email.email' => 'Ingresa una dirección de correo valida.',
            'phone.required' => 'Si nos dejas tu número de teléfono, podemos contactarte mas rápido.',
            'phone.digits' => 'Introduce un número valido de :digits dígitos',
            'message.required' => 'Aquí puedes compartirnos tus dudas a cerca de nuestros servicios.',
        ];
    }
}
