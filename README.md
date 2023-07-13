# A Laravel package that allows for ratings to be added to a Model

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cjmellor/rating.svg?style=flat-square)](https://packagist.org/packages/cjmellor/rating)
[![Total Downloads](https://img.shields.io/packagist/dt/cjmellor/rating.svg?style=flat-square)](https://packagist.org/packages/cjmellor/rating)

Imagine you have a Recipes Model and you want to have your Users' rate your culinary delights. This package allows you to achieve this.

![](https://banners.beyondco.de/Rating.png?theme=dark&packageManager=composer+require&packageName=cjmellor%2Frating&pattern=slantedStars&style=style_2&description=Rate+your+Models&md=1&showWatermark=0&fontSize=100px&images=star&widths=400&heights=400)

### Example

Add a `CanBeRated` trait to the Model you want to be ratable.

```php
use Cjmellor\Rating\Concerns\CanBeRated;

class Recipe extends Model
{
    use CanBeRated;
    
    // ...
}
```

Now you can rate any Model.

```php
$recipe = Recipe::find(1);

$recipe->rate(4);
```

## Installation

You can install the package via composer:

```shell
composer require cjmellor/rating
```

You can publish and run the migrations with:

```shell
php artisan vendor:publish --tag="rating-migrations"
php artisan migrate
```

You can publish the config file with:

```shell
php artisan vendor:publish --tag="rating-config"
```

This is the contents of the published config file:

```php
return [
    'users' => [
        'table' => 'users',
        'primary_key' => 'user_id',
    ],

    'max_rating' => 5,
];
```

## Usage

To rate a Model, you must add the `CanBeRated` trait to the Model in question.

```php
use Cjmellor\Rating\Concerns\CanBeRated;

class Recipe extends Model
{
    use CanBeRated;
    
    // ...
}
```

Now you can rate this Model:

```php
$recipe = Recipe::find(1);

$recipe->rate(score: 2);
```

You can view how many ratings a particular Model has:

```php
$recipe->ratings;

// this will return a Collection
```

You can get an overall percentage of the amount of Users' who have rated a Model:

Imagine you want a five-star rating system, and you have a Model that has been rated a `3` and a `5` by two Users'

```php
$recipe->ratingPercent(maxLength: 5);

// 80.0
```

This will equate to 80%. A float is returned. Changing the `maxLength` will recalculate the percentage.

The package comes with a bunch of Attributes that you can use. _The results of these are based off a single Model been rated by two Users' with a `3` and ` 5` rating._

```php
$recipe->averageRating; // "4.0000"
$recipe->averageRatingByUser; // "5.0000"
$recipe->averageSumOfUser; // 5
$recipe->ratedByUsers; // 2
$recipe->ratedInTotal; // 2
$recipe->sumRating; // "8" 
```

### Blade Component

The package comes with an optional blade component for displaying the Models' rating.

> **Warning**
> 
> You must have both TailwindCSS and FontAwesome installed, though FontAwesome can be replaced with your own preferred icon set**

You must publish the file to get access to it

```shell
php artisan vendor:publish --tag="rating-component"
```

You can now use the new component:

```html
<x-show-rating score="80.0" />
```

The component has customisable attributes:

```php
public string $color = 'text-yellow-400',
public string $family = 'FontAwesome',
public $innerStars = '\f005 \f005 \f005 \f005 \f005',
public $outerStars = '\f006 \f006 \f006 \f006 \f006',
public float $score = 0.0,
public string $textSize = 'text-2xl',
```

> **Info**
> 
> The component uses FontAwesome to generate the stars. You can use any icon library that supports using Unicode.

#### **"What about a component that allows you to rate a Model on the front-end?"**

That is out of the scope of this package. I may consider it in the future, or I am happy to receive a PR to add it.

## Testing

```shell
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/cjmellor/.github/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Chris Mellor](https://github.com/cjmellor)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
