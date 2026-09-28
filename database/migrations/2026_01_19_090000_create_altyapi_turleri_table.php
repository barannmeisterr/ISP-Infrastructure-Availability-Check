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
        Schema::create('altyapi_turleri', function (Blueprint $table) {
            $table->unsignedInteger('xdsltype'); // INT, auto increment yok
            $table->string('altyapi_adi', 50)->unique();
            $table->timestamps();

            $table->primary('xdsltype'); // primary key manuel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('altyapi_turleri');
    }
};

