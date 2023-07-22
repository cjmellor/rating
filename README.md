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
    
    'undo_rating' => true,
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

**Rate the Model**

```php
$recipe = Recipe::find(1);

$recipe->rate(score: 2);
```

**View Models' ratings**

```php
$recipe->ratings;
```

You can get an overall percentage of the amount of Users' who have rated a Model:

Imagine you want a five-star rating system, and you have a Model that has been rated a `3` and a `5` by two Users'

```php
$recipe->ratingPercent(maxLength: 5);

// 80.0
```

This will equate to 80%. A float is returned. Changing the `maxLength` will recalculate the percentage.

You could then use this percentage for the `score` attribute of the component.

> **Note**
> 
> By default, the `maxLength` is determined by a config option. You can override this by passing a value to the method.

**Unrating Models**

By default, you can unrate a Model. If you don't want Users' to unrate Models, set the `undo_rating` config option to true.

To unrate a Model, you can use the `unrate` method:

```php
$recipe->unrate();
```

The package comes with a bunch of Attributes that you can use. _The results of these are based off a single Model been rated by two Users' with a `3` and ` 5` rating._

```php
$recipe->averageRating; // "4.0000"
$recipe->averageRatingByUser; // "5.0000"
$recipe->averageSumOfUser; // 5
$recipe->ratedByUsers; // 2
$recipe->ratedInTotal; // 2
$recipe->sumRating; // "8" 
```

### Livewire Component

To see the ratings in action, you can use the Livewire component. This allows you to show the ratings on the front-end statically and let the User's rate the Model by clicking on the stars.

> **Warning**
> 
> You must have both Tailwind CSS and Font Awesome installed, though Font Awesome can be replaced with your own preferred icon set

**Use the component**

```html
<livewire:rating size="text-7xl" score="55" :model="$recipe" />
```

The component has customisable attributes, including:

```php
public string $iconBgColor = 'text-yellow-300';
public string $iconFgColor = 'text-yellow-400';
public string $iconBg = 'far fa-star';
public string $iconFg = 'fas fa-star';
public float $score = 0;
public string $size = 'text-base';
public bool $static = false;
```

If you have the config for unrating a Model set to `true`, an icon shows that allows you to unrate the Model. 

## Testing

```shell
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT Licence (MIT). Please see [Licence File](LICENSE.md) for more information.
