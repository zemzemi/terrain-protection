<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Services\TerrainProtectionService;
use Tests\TestCase;

class TerrainCalculateProtectionCommandTest extends TestCase
{
    public function test_run_command_with_valid_input(): void
    {
        $mockService = $this->createMock(TerrainProtectionService::class);
        $mockService->expects($this->once())
            ->method('calculateProtectionArea')
            ->willReturn(3);

        $this->app->instance(TerrainProtectionService::class, $mockService);

        $this->artisan('terrain:calculate-protection 5 "30 27 17 42 29"')
            ->expectsOutput('Protected area: 3')
            ->assertSuccessful();
    }

    public function test_prompts_for_missing_arguments(): void
    {
        $this->artisan('terrain:calculate-protection')
            ->expectsQuestion('Continent width', 5)
            ->expectsQuestion('Altitudes separated by spaces', '30 27 17 42 29')
            ->expectsOutput('Protected area: 3')
            ->assertSuccessful();
    }

    public function test_throws_error_for_invalid_width(): void
    {
        $this->artisan('terrain:calculate-protection 0 "30 27 17 42 29"')
            ->expectsOutput('The width field must be at least 1.')
            ->assertFailed();
    }

    public function test_throws_error_for_mismatched_altitudes_and_width(): void
    {
        $this->artisan('terrain:calculate-protection 5 "30 27 17 42"')
            ->expectsOutput('The number of altitudes must match the width of the continent.')
            ->assertFailed();
    }

    public function test_handles_large_dataset_efficiently(): void
    {
        $width = 100000;
        $altitudeString = implode(' ', range(100000, 1));

        $mockService = $this->createMock(TerrainProtectionService::class);
        $mockService->expects($this->once())
            ->method('calculateProtectionArea')
            ->willReturn(99999);

        $this->app->instance(TerrainProtectionService::class, $mockService);

        $this->artisan("terrain:calculate-protection {$width} \"{$altitudeString}\"")
            ->expectsOutput('Protected area: 99999')
            ->assertSuccessful();
    }
}
