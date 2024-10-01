<?php

use App\Models\Cat;
use App\DTOs\CatDTO;
use App\Models\User;

it('can return a list of cats', function () {
    // Creating two users for testing purposes
    $good_user = User::factory()->create();
    $bad_user = User::factory()->create();

    // Assignign 3 cats to the good user
    $good_user_cats = Cat::factory()->count(3)->create([
        'user_id' => $good_user->id,
    ]);
    
    // Mapping the cats to CatDTO
    $good_user_cats = $good_user_cats->map(
        function (Cat $cat) {
            $catDTO = new CatDTO([
                'name' => $cat->name,
                'breed' => $cat->breed,
                'date_of_birth' => $cat->date_of_birth,
                'weight' => $cat->weight,
                'user_id' => $cat->user_id,
            ]);
            return $catDTO->toArray();
        }
    );

    // Assigning 2 cats to the bad user
    Cat::factory()->count(2)->create([
        'user_id' => $bad_user->id,
    ]);

    // Getting the cats list for the good user
    $response = $this->actingAs($good_user)->getJson(route('cats.list'));

    // Asserting the response
    $response->assertJson($good_user_cats->toArray());
})->group('cats');