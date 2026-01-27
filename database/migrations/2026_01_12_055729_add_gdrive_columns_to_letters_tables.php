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
        // Add Google Drive columns to incoming_letters
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->string('gdrive_file_id')->nullable()->after('file_size');
            $table->string('gdrive_file_name')->nullable()->after('gdrive_file_id');
        });

        // Add Google Drive columns to outgoing_letters
        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->string('gdrive_file_id')->nullable()->after('file_size');
            $table->string('gdrive_file_name')->nullable()->after('gdrive_file_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropColumn(['gdrive_file_id', 'gdrive_file_name']);
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropColumn(['gdrive_file_id', 'gdrive_file_name']);
        });
    }
};
