<?php

use App\Models\Cat;
use App\Models\User;

it('can update an existing cat', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();

    // Creating a new cat
    $cat = Cat::factory()->create([
        'user_id' => $user->id,
    ]);

    // Creating the new cat data
    $newCatData = Cat::factory()->make([
        'user_id' => $user->id,
    ])->toArray();

    // Creating the request
    $response = $this->actingAs($user)->putJson(route('cats.update', $cat), $newCatData);

    // Asserting the response
    $response->assertOk();
    $this->assertDatabaseHas('cats', $newCatData);
    $this->assertDatabaseMissing('cats', $cat->toArray());
})->group('cats');

it('cannot update a cat that does not exist', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();

    // Creating the new cat data
    $newCatData = Cat::factory()->make([
        'user_id' => $user->id,
    ])->toArray();

    // Creating the request for a non-existing cat
    $response = $this->actingAs($user)->putJson(route('cats.update', 1), $newCatData);

    // Asserting the response
    $response->assertNotFound();
})->group('cats');

it('cannot update a cat without being authenticated', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();

    // Creating a new cat
    $cat = Cat::factory()->create([
        'user_id' => $user->id,
    ]);

    // Creating the new cat data
    $newCatData = Cat::factory()->make([
        'user_id' => $cat->user_id,
    ])->toArray();

    // Creating the request without authenticating the user
    $response = $this->putJson(route('cats.update', $cat), $newCatData);

    // Asserting the response
    $response->assertUnauthorized();
})->group('cats');