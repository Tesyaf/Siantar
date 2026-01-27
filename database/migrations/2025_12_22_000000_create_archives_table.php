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
        Schema::create('archives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat')->nullable()->index();
            $table->string('jenis')->nullable()->index();
            $table->string('pengirim')->nullable()->index();
            $table->string('penerima')->nullable()->index();
            $table->string('perihal')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('file_path')->nullable();
            $table->string('storage_disk')->default('public');
            $table->string('original_filename')->nullable();
            $table->string('file_mime')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('drive_file_id')->nullable()->index();
            $table->string('drive_web_view_link')->nullable();
            $table->string('folder')->nullable()->index();
            $table->string('tags')->nullable();
            $table->string('status')->default('aktif')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
