<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->constrained()->onDelete('cascade'); // Relasi ke users
            $table->bigInteger('produk_id')->constrained()->onDelete('cascade'); // Relasi ke produk
            $table->bigInteger('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('cascade'); // Relasi ke pelanggan
            $table->integer('qyt')->default(1); // Jumlah produk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
