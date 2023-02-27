<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
             $table->boolean('featured');
             $table->string('title');
             $table->string('url');
             $table->string('imageUrl');
             $table->string('newsSite');
             $table->string('summary');
             $table->string('publishedAt');
             $table->unsignedBigInteger('launches_id');
             $table->foreign('launches_id')
                   ->references('id')
                   ->on('launches');
            $table->unsignedBigInteger('events_id');
            $table->foreign('events_id')
                  ->references('id')
                  ->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
