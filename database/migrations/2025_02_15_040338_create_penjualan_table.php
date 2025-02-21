<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur');
            $table->date('tgl_faktur');
            $table->decimal('total_bayar', 10, 2);
            $table->bigInteger('pelanggan_id')->unsigned();
            $table->bigInteger('user_id')->unsigned(); // Kasir yang menangani
            $table->string('metode_pembayaran')->nullable(); // cash, debit, e-wallet
            $table->timestamps();
        
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down() {
        Schema::dropIfExists('penjualan');
    }
};


