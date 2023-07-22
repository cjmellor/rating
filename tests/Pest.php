<?php

use Cjmellor\Rating\Tests\Models\FakeUser;
use Cjmellor\Rating\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class)
    ->beforeEach(function () {
        // Create 2 fake Users' and persist to the Database
        [$this->user, $this->secondUser] = FakeUser::factory()->times(count: 2)->create([
            'username' => fake()->userName,
            'password' => fake()->password,
        ]);
    })
    ->in(__DIR__);
