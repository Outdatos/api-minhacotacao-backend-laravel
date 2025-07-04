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
        Schema::table('products', function (Blueprint $table) {
        $table->unsignedBigInteger('empresa_id')->nullable();

        $table->foreign('empresa_id')
              ->references('id')
              ->on('empresas')
              ->onDelete('set null'); // ou 'cascade' dependendo da regra do seu negócio
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
        $table->dropForeign(['empresa_id']);
        $table->dropColumn('empresa_id');
        });
    }
};
