<?php

use App\Models\Country;
use App\Models\User;

test('multimedia index loads successfully', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/multimedia/index');

    $response->assertStatus(200);
});

test('trivia index loads successfully', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/trivia/index');

    $response->assertStatus(200);
});

test('trivia play loads successfully for existing country', function () {
    $user = User::factory()->create();
    $country = Country::first();

    if (! $country) {
        $this->markTestSkipped('No countries in database.');
    }

    $response = $this->actingAs($user)->get('/trivia/questions/'.$country->slug);

    $response->assertStatus(200);
});
