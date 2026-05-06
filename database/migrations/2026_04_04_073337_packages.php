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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['tarot','palm','chat','call']);
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('question_limit')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('is_online')->default(true);
            $table->boolean('is_offline')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
