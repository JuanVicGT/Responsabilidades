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
        Schema::table('users', function (Blueprint $table) {
            // === Update columns ===
            $table->string('name', 150)->change();
            $table->string('email')->nullable()->change();

            // === Add new columns ===

            // User can edit (extras: name, email and password)
            $table->date('birthdate')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->string('avatar')->nullable();
            $table->string('address', 100)->nullable();

            // Only admin can edit
            $table->string('code', 30)->nullable();
            $table->string('username', 30)->unique(); // required - login
            $table->string('work_row', 30)->nullable();
            $table->string('work_position', 50)->nullable();
            $table->string('dependency', 50)->nullable();
            $table->boolean('is_admin')->nullable();
            $table->boolean('is_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
