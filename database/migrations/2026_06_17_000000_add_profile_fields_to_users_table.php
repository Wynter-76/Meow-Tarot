<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->longText('foto')->nullable()->after('password');
            $table->double('lat')->nullable()->after('foto');
            $table->double('lng')->nullable()->after('lat');
            $table->boolean('is_online')->default(false)->after('lng');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto', 'lat', 'lng', 'is_online']);
        });
    }
};
