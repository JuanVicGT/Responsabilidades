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
        Schema::table('responsability_sheets', function (Blueprint $table) {
            // Eliminar columnas
            $table->dropColumn(['series', 'total']);

            // Nuevas columnas
            $table->string('number')->nullable();
            $table->double('balance')->nullable();

            $table->string('status', 20)->nullable(); // Queda abierto

            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsability_sheets', function (Blueprint $table) {
            //
        });
    }
};
