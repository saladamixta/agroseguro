<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agro_empresas_autorizadas', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 20)->unique();
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('municipio')->nullable();
            $table->string('registro_mapa')->nullable();
            $table->boolean('ativa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agro_empresas_autorizadas');
    }
};
