<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penjualan_id')->unsigned();
            $table->bigInteger('produk_id')->unsigned();
            $table->decimal('harga_jual', 10, 2);
            $table->integer('jumlah');
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();
        
            $table->foreign('penjualan_id')->references('id')->on('penjualan')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });        
    }

    public function down() {
        Schema::dropIfExists('detail_penjualan');
    }
};


