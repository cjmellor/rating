<?php

use Cjmellor\Rating\Exceptions\CannotBeRatedException;
use Cjmellor\Rating\Exceptions\MaxRatingException;
use Cjmellor\Rating\Models\Rating;
use Cjmellor\Rating\Tests\Models\FakeUser;

test(description: 'a Model can be rated', closure: function () {
    // Create a Rating and attach to a fake User
    $this->user->rate(5);

    // Checking that the 'ratings' table has the rating
    $this->assertDatabaseHas(Rating::class, [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => 1,
        'user_id' => null,
        'rating' => 5,
    ]);
});

test(description: 'a logged in User can rate a Model', closure: function () {
    // log in as the fake User and assert the fake User is logged in
    $this->actingAs($this->secondUser)
        ->assertAuthenticatedAs($this->secondUser);

    // rate the fake User
    $this->user->rate(3);

    // assert the 'ratings' table has the record
    $this->assertDatabaseHas(table: Rating::class, data: [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => 1,
        'user_id' => $this->secondUser->id,
        'rating' => 3,
    ]);
});

test(description: 'a User cannot rate a Model more than once', closure: function () {
    // a logged-in User is required
    // sanity check that it logs in
    $this->actingAs($this->user)
        ->assertAuthenticated();

    // First, lets rate a User
    $this->user->rate(score: 5);

    // now, try rate the Model again
    $this->user->rate(score: 5);

    // assert that the 'ratings' table only has the one record
    $this->assertDatabaseCount(table: Rating::class, count: 1);
})->throws(exception: CannotBeRatedException::class, exceptionMessage: 'Cannot be rated more than once');

test(description: 'the amount of times a Model has been rated by a User', closure: function () {
    // create a User
    $user = FakeUser::factory()->createOne();

    // log in as a User and assert it's logged in
    $this->actingAs($this->user)
        ->assertAuthenticated();

    // Rate a User
    $user->rate(score: 2);

    expect($user->ratedByUsers)->toBe(expected: 1);
});

test(description: 'a Model can be rated by unauthorized Users', closure: function () {
    // create a User
    $user = FakeUser::factory()->createOne();

    // rate this User
    $user->rate(score: 3);

    // assert there is one rating
    expect($user->ratedInTotal)->toBe(expected: 1);

    // and the User is null
    $this->assertDatabaseHas(table: Rating::class, data: [
        'user_id' => null,
        'rating' => 3,
    ]);
});

test(description: 'the correct percentage of rated Models are calculated', closure: function () {
    config(['rating.max_rating' => 5]);

    // create a User to rate
    $user = FakeUser::factory()->createOne();

    // login as Fake User one and rate the User
    $this->actingAs($this->user)
        ->assertAuthenticated();

    $user->rate(score: 5);

    // now login as the Second User
    $this->actingAs($this->secondUser)
        ->assertAuthenticated();

    // and rate the User lower than the previous
    $user->rate(score: 3);

    // now assert the correct percentage, based on a rating system of 5
    expect($user->ratingPercent())
        ->toBe(expected: 80.0)
        ->and(value: 80.0)
        ->toBeFloat();
});

test(description: 'a Models rating percentage cannot exceed the specified max rating', closure: function () {
    // set a config for the max rating setting
    config(['rating.max_rating' => 4]);

    // create a User to rate against
    $user = FakeUser::factory()->createOne();

    // login and use User one to rate the User
    $this->actingAs($this->user)->assertAuthenticated();
    $user->rate(score: 5);

    // show the rating percentage
    $user->ratingPercent(maxRating: 5);
})->throws(exception: MaxRatingException::class, exceptionMessage: 'Maximum rating cannot be more than 4');

test(description: 'a Model can be unrated', closure: function () {
    $this->actingAs($this->secondUser)->assertAuthenticated();

    $this->user->rate(score: 5);

    $this->assertDatabaseHas(table: Rating::class, data: [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => 1,
        'user_id' => 2,
        'rating' => 5,
    ]);

    $this->user->unrate();

    $this->assertDatabaseMissing(table: Rating::class, data: [
        'rateable_type' => FakeUser::class,
        'rateable_id' => 1,
        'user_id' => 2,
        'rating' => 5,
    ]);
});

test(description: 'user_id in rating table is set to null when the related user is deleted', closure: function () {
    $this->actingAs($this->user)->assertAuthenticated();

    $this->secondUser->rate(score: 4);

    $this->assertDatabaseHas(table: Rating::class, data: [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => $this->secondUser->id,
        'user_id' => $this->user->id,
        'rating' => 4,
    ]);

    FakeUser::first()->delete();

    $this->assertDatabaseHas(table: Rating::class, data: [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => $this->secondUser->id,
        'user_id' => null,
        'rating' => 4,
    ]);
});
