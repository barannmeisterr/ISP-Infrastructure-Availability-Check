<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('iss_service_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iss_provider_id')
                ->constrained('iss_providers')
                ->cascadeOnDelete();
            $table->string('city')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iss_service_areas');
    }
};

