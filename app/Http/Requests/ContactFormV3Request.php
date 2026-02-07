<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaV3;
use App\Services\RecaptchaV3Service;
use Illuminate\Foundation\Http\FormRequest;

class ContactFormV3Request extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'             => 'required|string|max:100',
            'company'          => 'nullable|string|max:150',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:20',
            'service_interest' => 'required|string|in:monitoreo,redes,reputacion,reportes',
            'message'          => 'nullable|string|max:2000',
        ];

        // Add reCAPTCHA v3 validation (bypassed in local environment)
        if (RecaptchaV3Service::isEnabled()) {
            $rules['g-recaptcha-response'] = ['required', new RecaptchaV3('contact')];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'                     => 'Por favor, ingresa tu nombre completo.',
            'name.max'                          => 'El nombre no puede exceder los 100 caracteres.',
            'email.required'                    => 'Necesitamos tu correo electrónico para contactarte.',
            'email.email'                       => 'Por favor, ingresa un correo electrónico válido.',
            'service_interest.required'         => 'Selecciona el servicio de tu interés.',
            'service_interest.in'               => 'El servicio seleccionado no es válido.',
            'message.max'                       => 'El mensaje no puede exceder los 2000 caracteres.',
            'g-recaptcha-response.required'     => 'Error de verificación de seguridad.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'             => 'nombre',
            'company'          => 'empresa',
            'email'            => 'correo electrónico',
            'phone'            => 'teléfono',
            'service_interest' => 'servicio de interés',
            'message'          => 'mensaje',
        ];
    }
}
