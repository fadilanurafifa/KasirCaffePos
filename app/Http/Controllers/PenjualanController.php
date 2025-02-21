<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PenjualanController extends Controller
{
    public function index()
    {
        
        $pelanggan = Pelanggan::all();
        // $barang = Barang::all();
        $penjualan = Penjualan::with('pelanggan')->paginate(10);
        $produk = Produk::select('id', 'nama_produk', 'harga')->get();

        return view('admin.penjualan.index', compact('pelanggan', 'penjualan', 'produk'));
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            if (!$request->has('produk') || empty($request->produk)) {
                throw new \Exception("Tidak ada produk dalam transaksi.");
            }
    
            // Simpan data ke tabel `penjualan`
            $penjualan = Penjualan::create([
                'no_faktur' => 'INV-' . time(),
                'tgl_faktur' => now(),
                'total_bayar' => 0,
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => Auth::id(),
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);
    
            $totalBayar = 0;
    
            // Simpan detail penjualan
            foreach ($request->produk as $produk) {
                if (!isset($produk['id']) || !isset($produk['jumlah'])) {
                    throw new \Exception("Produk atau jumlah tidak ditemukan dalam request.");
                }
            
                $produkData = Produk::find($produk['id']);
            
                if (!$produkData) {
                    throw new \Exception("Produk dengan ID {$produk['id']} tidak ditemukan di database.");
                }
    
                $harga = (float) $produkData->harga;
                $jumlah = (int) $produk['jumlah'];
                $subtotal = $harga * $jumlah;
    
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => $produkData->id,
                    'harga_jual' => $harga,
                    'jumlah' => $jumlah,
                    'sub_total' => $subtotal,
                ]);
    
                $totalBayar += $subtotal;
            }
    
            // Update total bayar di tabel `penjualan`
            $penjualan->update(['total_bayar' => $totalBayar]);
    
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal',
                'error' => $e->getMessage(),
            ]);
        }
    }    
}

