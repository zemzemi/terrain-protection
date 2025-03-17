<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\DTOs\TerrainDataDTO;
use App\Http\Services\Contracts\ProtectionServiceInterface;

class TerrainProtectionService implements ProtectionServiceInterface
{
    public function calculateProtectionArea(TerrainDataDTO $dto): int
    {
        $highestPeak = 0;
        $protectedCount = 0;

        foreach ($dto->getAltitudes() as $altitude) {
            if ($altitude >= $highestPeak) {
                $highestPeak = $altitude;
            } else {
                $protectedCount++;
            }
        }

        return $protectedCount;
    }
}
