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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('code', 30)->nullable()->unique();
            $table->string('name', 150)->nullable();
            $table->string('serial', 150)->nullable();
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
            $table->string('series')->nullable();
            $table->text('observations')->nullable();
            $table->float('unit_value')->nullable();
            $table->float('amount')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
