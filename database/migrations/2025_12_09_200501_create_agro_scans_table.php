<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agro_scans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('file_path');              // caminho do arquivo da nota
            $table->longText('raw_text')->nullable(); // texto vindo do OCR

            $table->string('cnpj_emitente', 20)->nullable();
            $table->string('cnpj_comprador', 20)->nullable();
            $table->decimal('valor_total', 15, 2)->nullable();
            $table->date('data_emissao')->nullable();

            $table->boolean('empresa_autorizada')->nullable(); // true/false/null

            $table->json('dados_receita_emitente')->nullable();
            $table->json('dados_receita_comprador')->nullable();

            $table->longText('parecer_texto')->nullable(); // texto final gerado pela IA

            $table->string('status', 20)->default('pending'); // pending, processing, done, error
            $table->text('error_message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agro_scans');
    }
};
