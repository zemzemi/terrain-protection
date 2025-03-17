<?php

declare(strict_types=1);

namespace App\Http\Services\Contracts;

use App\Http\DTOs\TerrainDataDTO;

interface ProtectionServiceInterface
{
    public function calculateProtectionArea(TerrainDataDTO $dto): int;
}
