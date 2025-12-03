<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    private const SYMBOL_SET = '!@#$%^&*()-_=+[]{};:"\',.<>/?`~\\|';

    public function __construct(private int $minLength = 8)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $password = (string) $value;

        $hasLength = mb_strlen($password) >= $this->minLength;
        $hasUppercase = preg_match('/[A-Z]/', $password) === 1;
        $hasNumber = preg_match('/\d/', $password) === 1;
        $symbolPattern = '/[' . preg_quote(self::SYMBOL_SET, '/') . ']/';
        $hasSymbol = preg_match($symbolPattern, $password) === 1;

        if (!($hasLength && $hasUppercase && $hasNumber && $hasSymbol)) {
            $fail(__('password.requirements.summary'));
        }
    }
}
