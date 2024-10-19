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
            // Modificar columnas
            $table->double('quantity')->nullable()->change();
            $table->double('subtotal')->nullable()->change();

            // Nuevas columnas
            $table->boolean('is_active')->default(true);

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
