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
        Schema::create('lottery_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lottery_game_id')->constrained()->onDelete('cascade');
            $table->foreignId('lottery_draw_day_id')->constrained('lottery_draw_days')->onDelete('cascade');
            $table->foreignId('lottery_accumulated_id')->nullable()->constrained('lottery_accumulateds')->onDelete('set null');

            // Dados do Bolão
            $table->date('draw_date');                    // Dia do sorteio específico
            $table->decimal('quota_value', 10, 2);         // Valor da cota
            $table->integer('quota_quantity');             // Quantidade de cotas
            $table->integer('numbers_count');              // Número de dezenas
            $table->string('whatsapp_link');               // Link do WhatsApp
            $table->string('caixa_link')->nullable();      // Link do Loterias Caixa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_pools');
    }
};
