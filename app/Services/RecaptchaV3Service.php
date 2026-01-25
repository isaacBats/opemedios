<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaV3Service
{
    /**
     * Minimum score threshold for valid reCAPTCHA response.
     * 1.0 = very likely human, 0.0 = very likely bot
     */
    protected float $minScore;

    /**
     * Google reCAPTCHA verification endpoint.
     */
    protected string $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct()
    {
        $this->minScore = (float) config('services.recaptcha.min_score', 0.5);
    }

    /**
     * Verify a reCAPTCHA v3 token.
     *
     * @param string|null $token The g-recaptcha-response token from frontend
     * @param string|null $expectedAction The expected action name (optional)
     * @return array{success: bool, score: float|null, action: string|null, error: string|null}
     */
    public function verify(?string $token, ?string $expectedAction = null): array
    {
        // Bypass for local environment
        if ($this->shouldBypass()) {
            Log::debug('reCAPTCHA v3: Bypassing verification in local environment');
            return [
                'success' => true,
                'score' => 1.0,
                'action' => $expectedAction ?? 'bypass',
                'error' => null,
            ];
        }

        // Check if token is provided
        if (empty($token)) {
            Log::warning('reCAPTCHA v3: No token provided');
            return [
                'success' => false,
                'score' => null,
                'action' => null,
                'error' => 'Token de verificación no proporcionado.',
            ];
        }

        $secretKey = config('services.recaptcha.secret_key');

        if (empty($secretKey)) {
            Log::error('reCAPTCHA v3: Secret key not configured');
            return [
                'success' => false,
                'score' => null,
                'action' => null,
                'error' => 'reCAPTCHA no está configurado correctamente.',
            ];
        }

        try {
            $response = Http::asForm()->post($this->verifyUrl, [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $data = $response->json();

            Log::debug('reCAPTCHA v3 response', [
                'success' => $data['success'] ?? false,
                'score' => $data['score'] ?? null,
                'action' => $data['action'] ?? null,
                'hostname' => $data['hostname'] ?? null,
                'error-codes' => $data['error-codes'] ?? [],
            ]);

            if (!($data['success'] ?? false)) {
                $errorCodes = $data['error-codes'] ?? ['unknown-error'];
                Log::warning('reCAPTCHA v3: Verification failed', ['errors' => $errorCodes]);
                return [
                    'success' => false,
                    'score' => null,
                    'action' => null,
                    'error' => $this->getErrorMessage($errorCodes),
                ];
            }

            $score = (float) ($data['score'] ?? 0);
            $action = $data['action'] ?? null;

            // Validate action if expected action is provided
            if ($expectedAction !== null && $action !== $expectedAction) {
                Log::warning('reCAPTCHA v3: Action mismatch', [
                    'expected' => $expectedAction,
                    'received' => $action,
                ]);
                return [
                    'success' => false,
                    'score' => $score,
                    'action' => $action,
                    'error' => 'Acción de verificación no coincide.',
                ];
            }

            // Check score threshold
            if ($score < $this->minScore) {
                Log::warning('reCAPTCHA v3: Score below threshold', [
                    'score' => $score,
                    'threshold' => $this->minScore,
                ]);
                return [
                    'success' => false,
                    'score' => $score,
                    'action' => $action,
                    'error' => 'La verificación de seguridad no fue exitosa. Por favor, intenta de nuevo.',
                ];
            }

            return [
                'success' => true,
                'score' => $score,
                'action' => $action,
                'error' => null,
            ];

        } catch (\Exception $e) {
            Log::error('reCAPTCHA v3: Exception during verification', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'score' => null,
                'action' => null,
                'error' => 'Error al verificar el captcha. Por favor, intenta de nuevo.',
            ];
        }
    }

    /**
     * Check if reCAPTCHA verification should be bypassed.
     */
    protected function shouldBypass(): bool
    {
        // Bypass in local environment
        if (app()->environment('local', 'testing')) {
            return true;
        }

        // Optional: bypass if explicitly disabled via config
        if (config('services.recaptcha.enabled') === false) {
            return true;
        }

        return false;
    }

    /**
     * Get human-readable error message from error codes.
     */
    protected function getErrorMessage(array $errorCodes): string
    {
        $messages = [
            'missing-input-secret' => 'Error de configuración del servidor.',
            'invalid-input-secret' => 'Error de configuración del servidor.',
            'missing-input-response' => 'Token de verificación no proporcionado.',
            'invalid-input-response' => 'Token de verificación inválido.',
            'bad-request' => 'Solicitud malformada.',
            'timeout-or-duplicate' => 'El token ha expirado o ya fue usado. Por favor, intenta de nuevo.',
        ];

        foreach ($errorCodes as $code) {
            if (isset($messages[$code])) {
                return $messages[$code];
            }
        }

        return 'Error de verificación. Por favor, intenta de nuevo.';
    }

    /**
     * Get the site key for frontend use.
     */
    public static function getSiteKey(): ?string
    {
        return config('services.recaptcha.site_key');
    }

    /**
     * Check if reCAPTCHA is enabled and configured.
     */
    public static function isEnabled(): bool
    {
        if (app()->environment('local', 'testing')) {
            return false;
        }

        return !empty(config('services.recaptcha.site_key'))
            && !empty(config('services.recaptcha.secret_key'))
            && config('services.recaptcha.enabled', true);
    }
}
