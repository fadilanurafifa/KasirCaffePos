<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        dd($request->all());


        $keranjang = json_decode($request->query('keranjang'), true);
    
        $penjualan = Penjualan::with('pelanggan')->paginate(10);
        $produk = Produk::select('id', 'nama_produk', 'harga', 'stok')->get();
    
        return view('admin.penjualan.index', compact('penjualan', 'produk', 'keranjang'));
    }
    
    

    public function store(Request $request)
{

    dd($request->all());
    try {
        // Simpan transaksi
        Penjualan::create([
            'no_faktur' => $request->no_faktur,
            'tgl_faktur' => $request->tgl_faktur,
            'pelanggan_id' => $request->pelanggan_id,
            'user_id' => Auth::user()->id,
            'total_bayar' => $request->total_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil!');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}
