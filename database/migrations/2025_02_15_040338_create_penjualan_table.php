<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur')->unique();
            $table->date('tgl_faktur');
            $table->double('total_bayar');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('penjualan');
    }
};

