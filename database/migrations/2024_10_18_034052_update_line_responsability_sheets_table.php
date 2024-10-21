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
        Schema::table('line_responsability_sheets', function (Blueprint $table) {
            // Eliminar columnas
            $table->dropColumn(['subtotal', 'quantity']);

            // Nuevas columnas
            $table->date('date')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('is_active')->default(true);

            $table->double('balance')->nullable();
            $table->double('cash_in')->nullable();
            $table->double('cash_out')->nullable();

            $table->text('observations')->nullable();

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_responsability_sheets', function (Blueprint $table) {
            //
        });
    }
};
