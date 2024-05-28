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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->date('start_date');
            $table->string('status')->nullable();
            $table->date('end_date')->nullable();
            $table->date('start_hour')->nullable();
            $table->date('end_hour')->nullable();
            $table->string('description')->nullable();
            
            $table->int('id_responsible')->nullable();
            $table->foreignId('id_responsible')->nullable()->constrained('responsible')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
