<?php

namespace App\Actions\Cats;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteExistingCat
{
    use AsAction;

    public function handle(int $userId, int $catId): void
    {
        // Handle the deletion of an existing cat
        $cat = Cat::find($catId);

        // Check if the cat exists
        if (!$cat) {
            abort(404);
        }

        // Check if the authenticated user is the owner of the cat
        if ($cat->user_id !== $userId) {
            abort(403);
        }

        $cat->delete();
    }

    public function asController(Request $request, int $catId): JsonResponse
    {
        return response()->json($this->handle($request->user()->id, $catId), 204);
    }
}
