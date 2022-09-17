<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(table: 'ratings', callback: function (Blueprint $table): void {
            $table->id();
            $table->morphs(name: 'rateable');
            $table->foreignId(column: config(key: 'rating.users.primary_key'))
                ->nullable()
                ->constrained();
            $table->integer(column: 'rating');
            $table->timestamps();
        });
    }
};
