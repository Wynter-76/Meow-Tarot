<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'booking_id')) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('testimonials', 'rating')) {
                $table->integer('rating')->nullable()->after('booking_id');
            }
            if (!Schema::hasColumn('testimonials', 'package_name')) {
                $table->string('package_name')->nullable()->after('rating');
            }
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            foreach (['booking_id', 'rating', 'package_name'] as $col) {
                if (Schema::hasColumn('testimonials', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
