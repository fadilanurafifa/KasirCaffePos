<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function tambahKeCart(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produk,id'
        ]);
    
        // Ambil produk berdasarkan ID, jika tidak ditemukan return error
        $produk = Produk::where('id', $request->produk_id)->first();
    
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
    
        // Tambahkan produk ke keranjang, update qty jika sudah ada
        $cartItem = Cart::where('produk_id', $produk->id)->first();
    
        if ($cartItem) {
            $cartItem->update(['qty' => $cartItem->qty + 1]);
        } else {
            Cart::create([
                'produk_id' => $produk->id,
                'qty' => 1
            ]);
        }
    
        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
    }
    
}
