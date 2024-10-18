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
        Schema::create('transfer_responsibility_sheets', function (Blueprint $table) {
            $table->id();

            $table->date('date')->nullable();
            $table->string('description')->nullable();

            $table->foreignId('id_item')->constrained('items')->onDelete('cascade');

            $table->foreignId('id_from_sheet')->constrained('responsability_sheets')->onDelete('cascade');
            $table->foreignId('id_to_sheet')->nullable()->constrained('responsability_sheets');

            $table->foreignId('id_from_line')->constrained('line_responsability_sheets')->onDelete('cascade');
            $table->foreignId('id_to_line')->nullable()->constrained('line_responsability_sheets');

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_responsibility_sheets');
    }
};
