<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model {
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = [
        'no_faktur',
        'tgl_faktur',
        'pelanggan_id',
        'user_id',
        'total_bayar',
        'metode_pembayaran', // Pastikan ada di sini
    ];    

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
