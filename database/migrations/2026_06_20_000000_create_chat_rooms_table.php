<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reader_id')->nullable()->constrained('users')->nullOnDelete();

            // Penanda: customer ini beli add-on atau tidak (snapshot saat room dibuat)
            $table->boolean('has_addon')->default(false);

            $table->enum('status', ['open', 'closed'])->default('open');

            $table->timestamps();

            // Satu booking hanya punya satu room
            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};
