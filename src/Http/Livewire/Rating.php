<?php

namespace Cjmellor\Rating\Http\Livewire;

use Cjmellor\Rating\Exceptions\CannotBeRatedException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Rating extends Component
{
    public string $color = 'text-yellow-400';
    public $hoverValue = 0;
    public string $iconBg = 'far fa-star';
    public string $iconFg = 'fas fa-star';
    public Model $model;
    public float $score = 0;
    public string $size = 'text-base';
    public int $starRating;
    public bool $static = false;

    public function mount(): void
    {
        $this->starRating = config(key: 'rating.max_rating');

        $this->static = $this->model->alreadyRated();
    }

    public function setRating($value): void
    {
        $this->model->rate($value);

        $this->score = $this->model->ratingPercent();

        $this->static = true;
    }

    public function getStarWidth($index): int
    {
        if ($this->hoverValue > 0) {
            return $index <= $this->hoverValue ? 100 : 0;
        }

        $fullStars = floor(num: $this->score / 20);

        if ($index <= $fullStars) {
            return 100;
        }

        if ($index == $fullStars + 1) {
            return $this->score;
        }

        return 0;
    }

    public function render(): View
    {
        return view('rating::livewire.rating');
    }
}
