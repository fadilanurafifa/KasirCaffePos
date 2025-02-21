<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->decimal('total_bayar', 10, 2)->change(); // Ubah total_bayar menjadi decimal
        });
    }
    
    public function down() {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->double('total_bayar')->change(); // Kembalikan ke tipe sebelumnya jika rollback
        });
    }
    
};
