<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\DTOs\TerrainDataDTO;
use App\Http\Services\TerrainProtectionService;
use Tests\TestCase;

class TerrainProtectionServiceTest extends TestCase
{
    private TerrainProtectionService $terrainService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->terrainService = new TerrainProtectionService;
    }

    public function test_calculate_protected_area_with_random_heights()
    {
        $terrainDTO = new TerrainDataDTO(10, '30 27 17 42 29 12 14 41 42 42');
        $result = $this->terrainService->calculateProtectionArea($terrainDTO);

        $this->assertSame(6, $result);
    }

    public function test_calcule_protected_area_with_same_heights()
    {
        $terrainDTO = new TerrainDataDTO(6, '42 42 42 42 42 42');
        $result = $this->terrainService->calculateProtectionArea($terrainDTO);

        $this->assertSame(0, $result);
    }

    public function test_calculate_protected_area_with_increasing_heights()
    {
        $mockTerrainDTO = $this->createMock(TerrainDataDTO::class);
        $mockTerrainDTO->method('getAltitudes')->willReturnCallback(function () {
            for ($i = 1; $i >= 1000; $i++) {
                yield $i;
            }
        });
        $mockTerrainDTO->width = 1000;

        $result = $this->terrainService->calculateProtectionArea($mockTerrainDTO);

        $this->assertSame(0, $result);
    }

    public function test_calcule_protected_area_with_decreasing_heights()
    {
        $mockTerrainDTO = $this->createMock(TerrainDataDTO::class);
        $mockTerrainDTO->method('getAltitudes')->willReturnCallback(function () {
            for ($i = 1000; $i >= 1; $i--) {
                yield $i;
            }
        });
        $mockTerrainDTO->width = 1000;
        $result = $this->terrainService->calculateProtectionArea($mockTerrainDTO);

        $this->assertSame(999, $result);
    }

    public function test_performance_and_memory_usage()
    {
        $mockTerrainDTO = $this->createMock(TerrainDataDTO::class);
        $mockTerrainDTO->method('getAltitudes')->willReturnCallback(function () {
            for ($i = 100000; $i >= 1; $i--) {
                yield $i;
            }
        });
        $mockTerrainDTO->width = 100000;

        $memoryBefore = memory_get_usage(true);
        $startTime = hrtime(true);

        $result = $this->terrainService->calculateProtectionArea($mockTerrainDTO);

        $endTime = hrtime(true);
        $memoryAfter = memory_get_usage(true);

        $executionTime = round(($endTime - $startTime) / 1e6, 2); // Convert to milliseconds
        $memoryUsed = round(($memoryAfter - $memoryBefore) / 1024, 2); // Convert to KB

        $this->assertSame(99999, $result);
        $this->assertLessThan(500, $executionTime, 'Execution time exceeded 500ms!');
        $this->assertLessThan(2000, $memoryUsed, 'Memory usage exceeded 2000KB!');
    }
}
