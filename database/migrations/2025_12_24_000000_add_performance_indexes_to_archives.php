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
        Schema::table('archives', function (Blueprint $table) {
            // Indexing kolom yang sering dipakai untuk filter/pencarian
            // Ini membuat pencarian menjadi INSTANT (O(log n)) dibanding scan biasa (O(n))
            $table->index('jenis');     // Cepat filter surat masuk/keluar
            $table->index('pengirim');  // Cepat cari history pengirim
            $table->index('penerima');  // Cepat cari surat untuk siapa
            $table->index('folder');    // Cepat buka folder virtual
            
            // Index untuk status agar query default (misal: where status='aktif') tidak berat
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->dropIndex(['jenis']);
            $table->dropIndex(['pengirim']);
            $table->dropIndex(['penerima']);
            $table->dropIndex(['folder']);
            $table->dropIndex(['status']);
        });
    }
};
