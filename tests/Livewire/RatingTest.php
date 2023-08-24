<?php

use Cjmellor\Rating\Livewire\Rating;
use Livewire\Livewire;

beforeEach(closure: function (): void {
    config()->set('app.key', value: sprintf('base64:%s', base64_encode(string: random_bytes(length: 32))));
    config()->set('rating.max_rating', 5);
});

test(description: 'Data is correctly passed to the Rating component', closure: function () {
    Livewire::test(Rating::class, ['model' => $this->user, 'score' => 55])
        ->assertSet(name: 'model', value: $this->user)
        ->assertSet(name: 'score', value: 55)
        ->assertSet(name: 'starRating', value: 5);
});

test(description: 'A rating can be set', closure: function () {
    Livewire::test(Rating::class, ['model' => $this->user])
        ->call('setRating', 5)
        ->assertSet(name: 'hoverValue', value: 0)
        ->assertSet(name: 'modelRated', value: true)
        ->assertSet(name: 'score', value: 100.0)
        ->assertSet(name: 'static', value: true);

    $this->assertDatabaseHas(table: 'ratings', data: [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => 1,
        'user_id' => null,
        'rating' => 5,
    ]);
});

test(description: 'A rating can be reset', closure: function () {
    Livewire::test(Rating::class, ['model' => $this->user])
        ->call('setRating', 5)
        ->call(method: 'undoRating')
        ->assertSet(name: 'modelRated', value: false)
        ->assertSet(name: 'static', value: false);

    $this->assertDatabaseMissing(table: 'ratings', data: [
        'rateable_type' => 'Cjmellor\Rating\Tests\Models\FakeUser',
        'rateable_id' => 1,
        'user_id' => null,
        'rating' => 5,
    ]);
});
