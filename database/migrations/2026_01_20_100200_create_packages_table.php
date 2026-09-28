<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('iss_provider_id')
                ->nullable()
                ->constrained('iss_providers')
                ->nullOnDelete();

            $table->string('title')->index();




            // YENİ (domain controlled)
            $table->unsignedInteger('xdsltype')->nullable();

            // 🔗 FOREIGN KEY
            $table->foreign('xdsltype')
                ->references('xdsltype')
                ->on('altyapi_turleri')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->integer('download')->nullable()->index(); // 100 Mbps
            $table->integer('upload')->nullable()->index();   // 10 Mbps

            $table->decimal('price', 10, 2)->nullable()->index();

            $table->boolean('commitment')->default(false)->index();
            $table->unsignedInteger('commitment_month')->nullable();

            $table->boolean('quota')->default(false)->index();
            $table->string('ping')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
