<?php

use App\Models\Cat;
use App\Models\User;

it('deletes an existing cat', function () {
    // Create a user and a cat associated with that user
    $user = User::factory()->create();
    $cat = Cat::factory()->create([
        'user_id' => $user->id
    ]);

    // Delete the cat
    $response = $this->actingAs($user)->deleteJson(route('cats.delete', $cat->id));

    // Assert that the cat was deleted
    $response->assertStatus(204);

    // Assert that the cat was deleted from the database
    $this->assertDatabaseMissing('cats', ['id' => $cat->id]);
})->group('cats');

it('cannot delete a cat that does not exist', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();

    // Delete a cat that does not exist
    $response = $this->actingAs($user)->deleteJson(route('cats.delete', 1));

    // Assert that the response status is 404
    $response->assertStatus(404);
})->group('cats');


it('cannot delete a cat that does not belong to the authenticated user', function () {
    // Creating a user for testing purposes
    $user = User::factory()->create();
    // Creating another user and a cat associated with that user
    $anotherUser = User::factory()->create();
    $cat = Cat::factory()->create([
        'user_id' => $anotherUser->id
    ]);

    // Attempt to delete the cat
    $response = $this->actingAs($user)->deleteJson(route('cats.delete', $cat->id));

    // Assert that the response status is 403
    $response->assertStatus(403);
})->group('cats');
