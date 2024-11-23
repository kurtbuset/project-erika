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
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('user_id') // Adds the new column
                  ->nullable()           // Allows it to be null (optional relationship)
                  ->constrained('users') // References the 'users' table
                  ->onDelete('set null'); // If a user is deleted, set this column to null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drops the foreign key constraint
            $table->dropColumn('user_id');   // Drops the column itself
        });
    }
};
