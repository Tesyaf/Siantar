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
            $table->string('category')->nullable()->after('subject');
            $table->text('summary')->nullable()->after('category');
            $table->string('status')->default('Baru')->after('summary');
            $table->date('reference_letter_date')->nullable()->after('index_code');
            $table->string('reference_letter_number')->nullable()->after('reference_letter_date');
            $table->string('instruction_number')->nullable()->after('reference_letter_number');
            $table->string('package_number')->nullable()->after('instruction_number');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->string('category')->nullable()->after('subject');
            $table->text('summary')->nullable()->after('category');
            $table->string('status')->default('Menunggu')->after('summary');
            $table->string('priority')->nullable()->after('status');
            $table->string('file_number')->nullable()->after('priority');
            $table->string('instruction_number')->nullable()->after('file_number');
            $table->string('package_number')->nullable()->after('instruction_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'summary',
                'status',
                'reference_letter_date',
                'reference_letter_number',
                'instruction_number',
                'package_number',
            ]);
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'summary',
                'status',
                'priority',
                'file_number',
                'instruction_number',
                'package_number',
            ]);
        });
    }
};