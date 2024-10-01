<?php

namespace App\Actions\Cats;

use App\Models\Cat;
use App\DTOs\CatDTO;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewCat
{
    use AsAction;

    public function handle(CatDTO $catDTO)
    {
        // Handle the creation of a new cat
        $cat = Cat::create($catDTO->toArray());
        return CatDTO::fromArray($cat->toArray());
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle(CatDTO::fromRequest($request)));
    }
}
