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

    public function handle(int $catId, CatDTO $catDTO): CatResource
    {
        $cat = Cat::find($catId);

        // Check if the cat exists
        if (!$cat) {
            abort(404);
        }

        // Check if the authenticated user is the owner of the cat
        if ($cat->user_id !== $catDTO->user_id) {
            abort(403);
        }

        // Handle the update of an existing cat
        $cat->update($catDTO->toArray());
        return new CatResource($cat);
    }

    public function asController(int $catId, CatDTO $catDTO): JsonResponse
    {
        return response()->json($this->handle($catId, $catDTO));
    }
}