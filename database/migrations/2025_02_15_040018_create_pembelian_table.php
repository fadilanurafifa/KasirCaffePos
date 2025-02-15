<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_masuk')->unique();
            $table->date('tanggal_masuk');
            $table->double('total');
            $table->foreignId('pemasok_id')->constrained('pemasok')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('pembelian');
    }
};

