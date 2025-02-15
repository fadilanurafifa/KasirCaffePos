<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan daftar barang
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        $kategori = Kategori::all();
        $produk = Produk::all(); // Ambil daftar produk
    
        // Generate kode barang otomatis
        $lastBarang = Barang::latest()->first();
        $nextNumber = $lastBarang ? ((int)substr($lastBarang->kode_barang, -4)) + 1 : 1;
        $kodeBarang = 'BRG-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    
        return view('admin.barang.index', compact('barang', 'kategori', 'kodeBarang', 'produk'));
    }  
    public function create()
    {
        $produk = Produk::all(); // Ambil semua produk
        return view('barang.create', compact('produk'));
    }
      

    
    // Menyimpan barang baru

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
    
        // Generate kode barang unik
        $kodeBarang = $this->generateKodeBarang();
    
        $barang = new Barang();
        $barang->kode_barang = $kodeBarang;
        $barang->produk_id = $request->produk_id;
        $barang->nama_barang = $request->nama_barang;
        $barang->satuan = $request->satuan;
        $barang->harga_jual = $request->harga_jual;
        $barang->stok = $request->stok;
        $barang->save();
    
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }
    
    private function generateKodeBarang()
    {
        $prefix = 'BRG-';
        
        // Cari kode terakhir di database
        $lastBarang = Barang::orderBy('id', 'desc')->first();
        
        if (!$lastBarang) {
            return $prefix . '0001'; // Jika belum ada barang, mulai dari BRG-0001
        }
    
        // Ambil angka terakhir, tambahkan 1
        $lastNumber = (int) str_replace($prefix, '', $lastBarang->kode_barang);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    
        return $prefix . $newNumber;
    }    
    

    // Menghapus barang
    public function destroy($id)
    {
        try {
            Barang::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Barang berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus barang!'], 500);
        }
    }
}
