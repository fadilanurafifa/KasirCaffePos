<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $produk = Produk::all();
        return view('admin.produk.index', compact('produk')); // Pastikan path sesuai
    }    

    // Menampilkan halaman tambah produk
    public function create()
    {
        return view('admin.produk.create'); // Sesuaikan path view
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:100'
        ]);

        Produk::create([
            'nama_produk' => $request->nama_produk
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan halaman edit produk
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk')); // Pastikan path sesuai
    }

    // Update data produk di database
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|max:100'
        ]);

        $produk->update([
            'nama_produk' => $request->nama_produk
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk dari database
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
