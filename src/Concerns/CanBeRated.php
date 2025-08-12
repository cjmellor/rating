<?php

namespace Cjmellor\Rating\Concerns;

use Cjmellor\Rating\Exceptions\CannotBeRatedException;
use Cjmellor\Rating\Exceptions\MaxRatingException;
use Cjmellor\Rating\Models\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CanBeRated
{
    /**
     * Rate a Model.
     *
     * @return \Illuminate\Database\Eloquent\Model|false
     *
     * @throws \Cjmellor\Rating\Exceptions\CannotBeRatedException
     * @throws \Throwable
     */
    public function rate(int $score): Model|bool
    {
        // a User cannot rate the same Model twice...
        throw_if(condition: $this->alreadyRated(), exception: CannotBeRatedException::class);

        $rating = new Rating;

        $rating->user_id = auth()->id();
        $rating->rating = $score;

        return $this->ratings()->save(model: $rating);
    }

    public function unrate(): bool
    {
        return $this->ratings()
            ->where(column: 'user_id', operator: '=', value: auth()->id())
            ->delete();
    }

    /**
     * A check to see if the User has already rated the Model.
     */
    public function alreadyRated(): bool
    {
        return $this->ratings()->whereHasMorph(
            relation: 'rateable',
            types: '*',
            callback: fn (Builder $query): Builder => $query->where(column: 'user_id', operator: '=', value: auth()->id())
        )->exists();
    }

    /**
     * Get the rating for a Model.
     */
    public function ratings(): MorphMany
    {
        return $this->morphMany(related: Rating::class, name: 'rateable');
    }

    /**
     * Get the all-round percentage of a rated Model.
     *
     *
     * @throws \Throwable
     */
    public function ratingPercent($maxRating = null): float|int
    {
        $maxRating ??= config(key: 'rating.max_rating');

        throw_if(condition: $maxRating > config(key: 'rating.max_rating'), exception: MaxRatingException::class);

        return ($this->rated_in_total * $maxRating) > 0
            ? $this->sum_rating / (($this->rated_in_total * $maxRating) / 100)
            : 0;
    }

    /**
     * The amount of times a Model has been rated by Users'.
     */
    protected function ratedByUsers(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ratings()
                ->whereNotNull(config(key: 'rating.users.primary_key', default: 'user_id'))
                ->groupBy(config(key: 'rating.users.primary_key', default: 'user_id'))
                ->pluck(config(key: 'rating.users.primary_key', default: 'user_id'))
                ->count()
        );
    }

    /**
     * The amount of times a Model has been rated in total.
     */
    protected function ratedInTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ratings()->count()
        );
    }

    /**
     * Get the average rating for a Model
     */
    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ratings()->avg(column: 'rating')
        );
    }

    /**
     * Get the rating sum for a Model
     */
    protected function sumRating(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ratings()->sum(column: 'rating')
        );
    }

    /**
     * Get the average rating for a Model rated by Users.
     */
    protected function averageRatingByUser(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ratings()
                ->where(config(key: 'rating.users.primary_key', default: 'user_id'), auth()->id())
                ->avg(column: 'rating')
        );
    }

    /**
     * Get the rating sum for a Model rated by Users.
     */
    protected function averageSumOfUser(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ratings()
                ->where(config(key: 'rating.users.primary_key', default: 'user_id'), auth()->id())
                ->sum(column: 'rating')
        );
    }
}
