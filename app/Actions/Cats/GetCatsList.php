<?php

namespace App\Actions\Cats;

use App\DTOs\CatDTO;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCatsList
{
    use AsAction;

    public function handle(User $user): Collection
    {
        // Get all cats that belong to the given user
        return Cat::whereHas('owner', function (Builder $query) use ($user) {
            $query->where('id', $user->id);
        })
        ->get()
        ->map(
            fn (Cat $cat) => new CatDTO([
                'name' => $cat->name,
                'breed' => $cat->breed,
                'date_of_birth' => $cat->date_of_birth,
                'weight' => $cat->weight,
                'user_id' => $cat->user_id,
            ])
        );
    }

    public function asController()
    {
        return response()->json($this->handle(Auth::user()));
    }
}
