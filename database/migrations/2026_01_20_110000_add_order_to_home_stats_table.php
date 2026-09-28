<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_stats', function (Blueprint $table) {
            if (!Schema::hasColumn('home_stats', 'order')) {
                $table->unsignedInteger('order')->default(0)->after('label');
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_stats', function (Blueprint $table) {
            if (Schema::hasColumn('home_stats', 'order')) {
                $table->dropColumn('order');
            }
        });
    }
};

