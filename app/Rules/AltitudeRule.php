<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AltitudeRule implements ValidationRule
{
    private int $expectedWidth;

    public function __construct(int $expectedWidth)
    {
        $this->expectedWidth = $expectedWidth;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $altitudeArray = preg_split('/\s+/', trim($value));

        if (count($altitudeArray) !== $this->expectedWidth) {
            $fail("The $attribute must contain $this->expectedWidth altitudes.");
        }

        foreach ($altitudeArray as $altitude) {
            if (!ctype_digit($altitude) || (int) $altitude < 0 || (int) $altitude > 100000) {
              $fail("Each $attribute must be an integer between 0 and 100000, separated by spaces.");
            }
        }
    }
}
