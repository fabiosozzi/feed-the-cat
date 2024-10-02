<?php

namespace App\Actions\Cats;

use App\Models\Cat;
use App\DTOs\CatDTO;
use App\Http\Resources\CatResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCatsList
{
    use AsAction;

    /**
     * Get all cats that belong to the given user
     *
     * @param User $user
     * @return Collection<CatDTO>
     */
    public function handle(User $user): Collection
    {
        return Cat::whereHas('owner', function (Builder $query) use ($user) {
            $query->where('id', $user->id);
        })
        ->get()
        ->map(
            fn (Cat $cat) => new CatResource($cat)
        );
    }

    public function asController(): JsonResponse
    {
        return response()->json($this->handle(Auth::user()));
    }
}
