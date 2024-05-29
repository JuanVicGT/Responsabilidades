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
        Schema::create('line_responsability_sheets', function (Blueprint $table) {
            $table->id();

            $table->float('quantity')->nullable();
            $table->float('subtotal')->nullable();

            $table->foreignId('id_item')->constrained('items')->onDelete('cascade');
            $table->foreignId('id_responsability_sheet')->constrained(
                table: 'responsability_sheets',
                indexName: 'line_responsability_sheet'
            )->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_responsability_sheets');
    }
};
