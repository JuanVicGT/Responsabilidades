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

            $table->string('name', 150);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status', 20)->nullable();
            $table->date('start_hour')->nullable();
            $table->date('end_hour')->nullable();
            $table->string('description')->nullable();

            $table->foreignId('id_responsible')->nullable()->constrained('users')->onDelete('cascade');
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
