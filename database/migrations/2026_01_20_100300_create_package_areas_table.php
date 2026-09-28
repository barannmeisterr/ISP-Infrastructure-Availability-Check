<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package_areas', function (Blueprint $table) {
            $table->id();

            // 🔗 Paket FK
            $table->foreignId('package_id')
                ->constrained('packages')
                ->cascadeOnDelete();


            $table->unsignedBigInteger('il_id')->nullable();
            $table->unsignedBigInteger('ilce_id')->nullable();
            $table->unsignedBigInteger('mahalle_id')->nullable();
            $table->unsignedBigInteger('csbm_id')->nullable();
            $table->unsignedBigInteger('bina_id')->nullable();

            $table->string('city')->nullable()->index();

            $table->timestamps();


            $table->index(['il_id', 'ilce_id', 'mahalle_id','csbm_id', 'bina_id'], 'idx_il_ilce_mahalle_csbm_bina');
            $table->unique(
                ['package_id','il_id','ilce_id','mahalle_id','csbm_id','bina_id'],
                'uniq_package_area_full'
            );

            $table->index(['package_id', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_areas');
    }
};


