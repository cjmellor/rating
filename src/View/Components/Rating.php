<?php

namespace Cjmellor\Rating\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rating extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $color = 'text-yellow-400',
        public string $family = 'FontAwesome',
        public $innerStars = '\f005 \f005 \f005 \f005 \f005',
        public $outerStars = '\f006 \f006 \f006 \f006 \f006',
        public float $score = 0.0,
        public string $textSize = 'text-2xl',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('rating::components.rating');
    }
}
