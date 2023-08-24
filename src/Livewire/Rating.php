<?php

namespace Cjmellor\Rating\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Rating extends Component
{
    public $hoverValue = 0;

    public string $iconBg = 'far fa-star';

    public string $iconBgColor = 'text-yellow-300';

    public string $iconFgColor = 'text-yellow-400';

    public string $iconFg = 'fas fa-star';

    public Model $model;

    public bool $modelRated;

    public float $score = 0;

    public bool $showSuccess = true;

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

        $this->modelRated = true;

        $this->score = $this->model->ratingPercent();

        $this->static = true;
    }

    public function undoRating(): void
    {
        $this->model->unrate();

        if ($this->modelRated) {
            $this->modelRated = false;
        }

        $this->score = $this->model->ratingPercent();

        $this->static = false;
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

    public function ratingCanBeChanged(): bool
    {
        return $this->static
            && auth()->check()
            && config(key: 'rating.undo_rating');
    }

    public function render(): View
    {
        return view('rating::livewire.rating');
    }
}
