<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Users' Table
    |--------------------------------------------------------------------------
    |
    | The table name used to store users'
    | The primary key used
    |
    | Defaults:
    | -- table: users
    | -- primary key: user_id
    |
    */
    'users' => [
        'table' => 'users',
        'primary_key' => 'user_id',
    ],

    /*
    |--------------------------------------------------------------------------
    | Max Rating
    |--------------------------------------------------------------------------
    |
    | The maximum rating a Model can be rated.
    |
    */
    'max_rating' => 5,

    /*
    |--------------------------------------------------------------------------
    | Undo Rating
    |--------------------------------------------------------------------------
    |
    | Whether or not a User can undo their rating.
    |
    */
    'undo_rating' => true,
];
