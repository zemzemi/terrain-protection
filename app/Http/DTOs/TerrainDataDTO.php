<?php

declare(strict_types=1);

namespace App\Http\DTOs;

use App\Http\Validation\TerrainDTOValidator;

class TerrainDataDTO
{
    public int $width;

    private string $altitudeString;

    public function __construct(
        int $width,
        string $altitudeString
    ) {
        TerrainDTOValidator::validate([
            'width' => $width,
            'altitudes' => $altitudeString,
        ]);

        $this->width = $width;
        $this->altitudeString = trim($altitudeString);
    }

    public function getAltitudes(): iterable
    {
        foreach (explode(' ', $this->altitudeString) as $altitude) {
            yield (int) $altitude;
        }
    }
}
