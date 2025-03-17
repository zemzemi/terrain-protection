<?php

namespace App\Http\Controllers;

use App\Http\DTOs\TerrainDataDTO;
use App\Http\Requests\TerrainProtectionRequest;
use App\Http\Services\Contracts\ProtectionServiceInterface;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TerrainProtectionController extends Controller
{
    private ProtectionServiceInterface $terrainService;

    public function __construct(ProtectionServiceInterface $terrainService)
    {
        $this->terrainService = $terrainService;
    }

    public function index()
    {
        return Inertia::render('ProtectionCalculate', [
            'result' => session('result', null),
        ]);
    }

    public function calculate(TerrainProtectionRequest $request)
    {
        $dto = new TerrainDataDTO(
            width: $request->validated()['width'],
            altitudeString: $request->validated()['altitudes']
        );

        $protectedArea = $this->terrainService->calculateProtectionArea($dto);

        return Redirect::route('terrain-protection.index')
            ->with('result', $protectedArea);
    }
}
