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
            $table->integer('number')->nullable();
            $table->string('prefix_number')->nullable();

            $table->double('balance')->nullable();
            $table->double('cash_in')->nullable();
            $table->double('cash_out')->nullable();

            $table->string('status', 20)->nullable(); // Queda abierto porque no me decido que pueda contener

            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
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
