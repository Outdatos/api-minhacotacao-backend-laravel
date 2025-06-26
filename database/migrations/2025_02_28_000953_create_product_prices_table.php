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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('faixa_id')->constrained('faixas_quantidade')->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable()->default(null); // Preço unitário nessa faixa
            $table->timestamps();

            $table->unique(['product_id', 'faixa_id']); // Garante que um produto tenha um único preço por faixa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
