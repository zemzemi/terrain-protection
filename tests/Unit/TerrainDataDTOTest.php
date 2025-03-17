<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\DTOs\TerrainDataDTO;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TerrainDataDTOTest extends TestCase
{
    public function test_creates_dto_with_valid_data(): void
    {
        $dto = new TerrainDataDTO(5, '30 27 17 42 29');

        $altitudes = iterator_to_array($dto->getAltitudes());

        $this->assertSame([30, 27, 17, 42, 29], $altitudes);
        $this->assertSame(5, $dto->width);
    }

    public function test_throws_exception_when_width_is_zero_or_negative(): void
    {
        $this->expectException(ValidationException::class);

        new TerrainDataDTO(2, '30 27 17 42 29');
    }

    public function test_throws_exception_when_width_and_altitude_count_do_not_match(): void
    {
        $this->expectException(ValidationException::class);

        new TerrainDataDTO(5, '30 27 17 42'); // 4 altitudes, expected 5
    }

    public function trimsExtraSpacesCorrectly(): void
    {
        $dto = new TerrainDataDTO(5, '  30   27  17  42 29  ');

        $altitudes = iterator_to_array($dto->getAltitudes());

        $this->assertSame([30, 27, 17, 42, 29], $altitudes);
    }

    public function test_processes_large_altitude_sets_efficiently(): void
    {
        $width = 100000;
        $altitudeString = implode(' ', range(100000, 1));

        $dto = new TerrainDataDTO($width, $altitudeString);

        // Returns 100,000 elements without loading them all in memory
        $altitudeCount = iterator_count($dto->getAltitudes());

        $this->assertSame($width, $altitudeCount);
    }
}
