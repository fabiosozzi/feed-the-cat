<?php

namespace App\Actions\Cats;

use App\DTOs\CatDTO;
use App\Models\Cat;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateExistingCat
{
    use AsAction;

    public function handle(Cat $cat, CatDTO $catDTO)
    {
        // Handle the update of an existing cat
        $cat->update($catDTO->toArray());
        return CatDTO::fromArray($cat->toArray());
    }

    public function asController(Cat $cat, CatDTO $catDTO)
    {
        return response()->json($this->handle($cat, $catDTO));
    }
}
