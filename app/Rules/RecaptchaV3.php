<?php

namespace App\Rules;

use App\Services\RecaptchaV3Service;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RecaptchaV3 implements ValidationRule
{
    /**
     * The expected action name for this reCAPTCHA verification.
     */
    protected ?string $action;

    /**
     * Create a new rule instance.
     *
     * @param string|null $action Expected action name (e.g., 'login', 'contact')
     */
    public function __construct(?string $action = null)
    {
        $this->action = $action;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $service = app(RecaptchaV3Service::class);
        $result = $service->verify($value, $this->action);

        if (!$result['success']) {
            $fail($result['error'] ?? 'La verificación de seguridad falló.');
        }
    }
}
