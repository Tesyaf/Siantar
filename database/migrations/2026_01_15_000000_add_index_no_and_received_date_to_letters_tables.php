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
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->unsignedInteger('index_no')->nullable()->index();
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->date('received_date')->nullable()->index();
            $table->unsignedInteger('index_no')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropColumn('index_no');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropColumn(['received_date', 'index_no']);
        });
    }
};
