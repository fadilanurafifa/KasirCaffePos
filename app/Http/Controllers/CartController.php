<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller

{
    public function store(Request $request)
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login
    
        dd($request->all()); // Debugging untuk melihat data yang dikirim
    
        // Validasi data yang diterima dari frontend
        $request->validate([
            'produk_id' => 'required|integer',
            'pelanggan_id' => 'nullable|integer',
            'qyt' => 'required|integer|min:1',
        ]);
    
        // Simpan produk ke dalam tabel cart
        $cart = Cart::create([
            'user_id' => $userId,
            'produk_id' => $request->produk_id,
            'pelanggan_id' => $request->pelanggan_id,
            'qyt' => $request->qyt,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart' => $cart
        ]);
    }
    
}

