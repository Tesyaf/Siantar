<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * This migration changes index_no from unsignedInteger to string
     * to support values like "19.1", "19.2", etc.
     * Existing data will be preserved and converted to string format.
     */
    public function up(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->string('index_no', 20)->nullable()->change();
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->string('index_no', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->unsignedInteger('index_no')->nullable()->change();
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->unsignedInteger('index_no')->nullable()->change();
        });
    }
};
