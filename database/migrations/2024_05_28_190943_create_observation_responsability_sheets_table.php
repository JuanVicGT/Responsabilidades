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
        Schema::create('observation_responsability_sheets', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);
            $table->string('description')->nullable();

            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_responsability_sheet')->constrained(
                table: 'responsability_sheets',
                indexName: 'ob_responsability_sheet'
            )->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_responsability_sheets');
    }
};
