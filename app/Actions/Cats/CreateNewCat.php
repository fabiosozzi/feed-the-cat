<?php

namespace App\Actions\Cats;

use App\Models\Cat;
use App\DTOs\CatDTO;
use App\Http\Resources\CatResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewCat
{
    use AsAction;

    /**
     * Handle the creation of a new cat
     *
     * @param CatDTO $catDTO
     * @return CatDTO
     */
    public function handle(CatDTO $catDTO): CatResource
    {
        $cat = Cat::create($catDTO->toArray());
        return new CatResource($cat);
    }

    public function asController(CatDTO $catDTO): JsonResponse
    {
        return response()->json($this->handle($catDTO));
    }
}
