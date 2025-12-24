<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->string('storage_disk')->default('public')->after('file_path');
            $table->string('original_filename')->nullable()->after('storage_disk');
            $table->string('file_mime')->nullable()->after('original_filename');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_mime');
            $table->string('drive_file_id')->nullable()->after('file_size');
            $table->string('drive_web_view_link')->nullable()->after('drive_file_id');

            $table->index('drive_file_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->dropIndex(['drive_file_id']);
            $table->dropColumn([
                'storage_disk',
                'original_filename',
                'file_mime',
                'file_size',
                'drive_file_id',
                'drive_web_view_link',
            ]);
        });
    }
};
