<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cnpj_cache', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 20)->unique();
            $table->json('dados');
            $table->timestamp('consultado_em');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cnpj_cache');
    }
};
