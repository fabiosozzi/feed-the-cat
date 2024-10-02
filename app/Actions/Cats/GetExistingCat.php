<?php

namespace App\Actions\Cats;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CatResource;
use Lorisleiva\Actions\Concerns\AsAction;

class GetExistingCat
{
    use AsAction;

    public function handle(int $userId, int $catId): CatResource
    {
        // Handle the retrieval of an existing cat
        $cat = Cat::find($catId);

        // Check if the cat exists
        if (!$cat) {
            abort(404);
        }

        // Check if the authenticated user is the owner of the cat
        if ($cat->user_id !== $userId) {
            abort(403);
        }
        return new CatResource($cat);
    }

    public function asController(Request $request, int $catId): JsonResponse
    {
        return response()->json($this->handle($request->user()->id, $catId));
    }
}
