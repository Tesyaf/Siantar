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
        Schema::create('archives', function (Blueprint $table) {
            // use UUID primary key instead of incrementing integer
            $table->uuid('id')->primary();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat')->nullable();
            $table->string('jenis')->nullable(); // misal: masuk / keluar
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            $table->string('perihal')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('file_path')->nullable(); // path lampiran di storage
            $table->string('folder')->nullable();
            $table->string('tags')->nullable();
            $table->string('status')->default('aktif'); // aktif / arsip
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tanggal_surat']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archives');
    }
};
