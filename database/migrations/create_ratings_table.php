<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->morphs('rateable');
            $table->foreignId((string) config(key: 'rating.users.primary_key', default: 'user_id'))->nullable()->constrained()->nullOnDelete();
            $table->integer('rating');
            $table->timestamps();
        });
    }
};
