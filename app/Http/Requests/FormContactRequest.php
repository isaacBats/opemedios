<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaV3;
use App\Services\RecaptchaV3Service;
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
        $rules = [
            'name'    => 'required|max:50',
            'email'   => 'required|email',
            'phone'   => 'required|digits:10',
            'message' => 'required',
        ];

        // Add reCAPTCHA v3 validation (bypassed in local environment)
        if (RecaptchaV3Service::isEnabled()) {
            $rules['g-recaptcha-response'] = ['required', new RecaptchaV3('contact')];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                 => 'Queremos conocerte. Por favor ingresa tu nombre.',
            'email.required'                => 'Dejanos una dirección de correo para poder estar en contacto contigo.',
            'email.email'                   => 'Ingresa una dirección de correo valida.',
            'phone.required'                => 'Si nos dejas tu número de teléfono, podemos contactarte mas rápido.',
            'phone.digits'                  => 'Introduce un número valido de :digits dígitos',
            'message.required'              => 'Aquí puedes compartirnos tus dudas a cerca de nuestros servicios.',
            'g-recaptcha-response.required' => 'Error de verificación de seguridad.',
        ];
    }
}
