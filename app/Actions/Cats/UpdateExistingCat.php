<?php

namespace App\Actions\Cats;

use App\DTOs\CatDTO;
use App\Http\Resources\CatResource;
use App\Models\Cat;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateExistingCat
{
    use AsAction;

    public function handle(Cat $cat, CatDTO $catDTO): CatResource
    {
        // Handle the update of an existing cat
        $cat->update($catDTO->toArray());
        return new CatResource($cat);
    }

    public function asController(Cat $cat, CatDTO $catDTO): JsonResponse
    {
        return response()->json($this->handle($cat, $catDTO));
    }
}
