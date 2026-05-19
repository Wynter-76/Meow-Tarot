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
        Schema::create('daily_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->string('card_name');
            $table->string('card_image');
            $table->string('keyword');
            $table->text('meaning');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_cards');
    }
};
