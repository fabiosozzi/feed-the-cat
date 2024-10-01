<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CatDTO extends ValidatedDTO
{
    protected function rules(): array
    {
        return [
            'name' => 'required|string',
            'breed' => 'required|string',
            'date_of_birth' => 'required|date',
            'weight' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
