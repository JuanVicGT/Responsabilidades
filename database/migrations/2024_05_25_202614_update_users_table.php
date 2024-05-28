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
            $table->string('email')->nullable()->change();

            // === Add new columns ===

            // User can edit (extras: name, email and password)
            $table->date('birthdate')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();

            // Only admin can edit
            $table->string('code', 30)->nullable();
            $table->string('username', 30)->unique(); // required - login
            $table->string('work_row')->nullable();
            $table->string('work_position')->nullable();
            $table->string('dependence')->nullable();
            $table->boolean('admin')->nullable();
            $table->boolean('status')->nullable();
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
