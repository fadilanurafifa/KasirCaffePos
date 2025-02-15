<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->double('harga_jual');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('barang');
    }
};
