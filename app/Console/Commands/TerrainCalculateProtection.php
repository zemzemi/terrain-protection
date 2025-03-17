<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\DTOs\TerrainDataDTO;
use App\Http\Services\Contracts\ProtectionServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class TerrainCalculateProtection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'terrain:calculate-protection {width?} {altitudes?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates the protected area from terrain altitudes.';

    private ProtectionServiceInterface $protectionService;

    public function __construct(ProtectionServiceInterface $protectionService)
    {
        parent::__construct();
        $this->protectionService = $protectionService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $width = $this->argument('width') ?? (int) $this->ask('Continent width');
        $altitudes = $this->argument('altitudes') ?? $this->ask('Altitudes separated by spaces');

        try {
            $dto = new TerrainDataDTO((int) $width, $altitudes);
            $result = $this->protectionService->calculateProtectionArea($dto);

            $this->info("Protected area: $result");

            return Command::SUCCESS;
        } catch (ValidationException $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
