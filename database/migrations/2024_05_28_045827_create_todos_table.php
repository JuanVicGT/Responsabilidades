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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150)->nullable();
            $table->string('status', 20)->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->string('description')->nullable();
            $table->date('year')->nullable();
            $table->date('month')->nullable();

            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
