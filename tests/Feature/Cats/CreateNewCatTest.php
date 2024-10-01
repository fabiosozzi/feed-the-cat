<?php

use App\Models\Cat;
use App\DTOs\CatDTO;
use App\Models\User;

it('can create a new cat', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();

    // Creating a new cat
    $cat = Cat::factory()->make();

    // Creating the cat DTO
    $catDTO = new CatDTO([
        'name' => $cat->name,
        'breed' => $cat->breed,
        'date_of_birth' => $cat->date_of_birth,
        'weight' => $cat->weight,
        'user_id' => $user->id,
    ]);

    // Creating the request
    $response = $this->actingAs($user)->postJson(route('cats.create'), $catDTO->toArray());

    // Asserting the response
    $response->assertJson($catDTO->toArray());
})->group('cats');

it('cannot create a new cat without being authenticated', function () {
    // Creating a new cat
    $cat = Cat::factory()->make();

    // Creating the cat DTO
    $catDTO = new CatDTO([
        'name' => $cat->name,
        'breed' => $cat->breed,
        'date_of_birth' => $cat->date_of_birth,
        'weight' => $cat->weight,
        'user_id' => 1,
    ]);

    // Creating the request
    $response = $this->postJson(route('cats.create'), $catDTO->toArray());

    // Asserting the response
    $response->assertUnauthorized();
})->group('cats');

it('cannot create a new cat with invalid data', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();

    // Creating the request
    $response = $this->actingAs($user)->postJson(route('cats.create'), []);

    // Asserting the response
    $response->assertJsonValidationErrors([
        'name',
        'breed',
        'date_of_birth',
        'weight',
        'user_id',
    ]);
})->group('cats');