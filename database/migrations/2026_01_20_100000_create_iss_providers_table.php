<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('iss_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('logo_path')->nullable()->index();
            $table->string('location')->nullable()->index();
            $table->json('services')->nullable();
            $table->text('company_info')->nullable();
            $table->string('cagrimerkezi')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('unvan')->nullable()->index();
            $table->string('address')->nullable();

            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iss_providers');
    }
};

