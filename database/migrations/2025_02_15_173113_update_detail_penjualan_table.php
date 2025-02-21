<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('detail_penjualan', function (Blueprint $table) {
            // Hapus foreign key lama (barang_id)
            $table->dropForeign(['barang_id']);
            $table->dropColumn('barang_id');

            // Tambahkan produk_id yang baru
            $table->foreignId('produk_id')->after('penjualan_id')
                  ->constrained('produk')
                  ->onDelete('restrict');
        });
    }

    public function down() {
        Schema::table('detail_penjualan', function (Blueprint $table) {
            // Hapus produk_id jika rollback
            $table->dropForeign(['produk_id']);
            $table->dropColumn('produk_id');

            // Tambahkan kembali barang_id
            $table->foreignId('barang_id')->after('penjualan_id')
                  ->constrained('barang')
                  ->onDelete('restrict');
        });
    }
};
