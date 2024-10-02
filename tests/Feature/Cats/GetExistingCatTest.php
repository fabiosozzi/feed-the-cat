<?php

use App\Models\Cat;
use App\Models\User;

it('can get an existing cat', function () {
    $user = User::factory()->create();
    $cat = Cat::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->getJson(route('cats.show', $cat->id));

    $response->assertOk();
    $response->assertJson([
        'name' => $cat->name,
        'breed' => $cat->breed,
        'date_of_birth' => $cat->date_of_birth,
        'weight' => $cat->weight,
        'user_id' => $cat->user_id,
    ]);
})->group('cats');

it('cannot get a non-existing cat', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson(route('cats.show', 1));

    $response->assertNotFound();
})->group('cats');

it('cannot get a cat that does not belong to the authenticated user', function () {
    $user = User::factory()->create();
    $another_user = User::factory()->create();
    $cat = Cat::factory()->create([
        'user_id' => $another_user->id,
    ]);

    $response = $this->actingAs($user)->getJson(route('cats.show', $cat->id));

    $response->assertForbidden();
})->group('cats');
