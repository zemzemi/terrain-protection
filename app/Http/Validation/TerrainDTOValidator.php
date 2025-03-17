<?php

declare(strict_types=1);

namespace App\Http\Validation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TerrainDTOValidator
{
    public static function validate(array $data): void
    {
        $rules = [
            'width' => ['required', 'integer', 'min:1'],
            'altitudes' => ['required', 'string'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        self::validateAltitude((int) $data['width'], $data['altitudes']);
    }

    private static function validateAltitude(int $width, string $altitudeString): void
    {
        $altitudeCount = 0;

        foreach (self::generateAltitudes($altitudeString) as $altitude) {
            $altitudeCount++;
            if ($altitude < 0 || $altitude > 100000) {
                throw ValidationException::withMessages([
                    'altitudes' => 'Altitudes must be between 0 and 100,000',
                ]);
            }
        }

        if ($altitudeCount !== $width) {
            throw ValidationException::withMessages(['altitudes' => 'The number of altitudes must match the width of the continent.']);
        }
    }

    private static function generateAltitudes(string $altitudeString): iterable
    {
        foreach (explode(' ', trim($altitudeString)) as $altitude) {
            if (! ctype_digit($altitude)) {
                throw ValidationException::withMessages([
                    'altitudes' => "Invalid altitude format detected: $altitude. Altitudes must be space-separated integers.",
                ]);
            }

            yield (int) $altitude;
        }
    }
}
