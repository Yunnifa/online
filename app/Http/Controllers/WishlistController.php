<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman wishlist pengguna.
     */
    public function index()
    {
        // Ambil semua item di wishlist milik user yang sedang login,
        // beserta data produk terkait.
        $wishlistItems = Auth::user()->wishlist()->with('product')->latest()->get();
        
        // Tampilkan view wishlist.index dengan data tersebut.
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Menambah atau menghapus produk dari wishlist.
     */
    public function toggle(Product $product)
    {
        // Cari item wishlist berdasarkan user yang login dan produk yang dipilih.
        $wishlistItem = Wishlist::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->first();

        if ($wishlistItem) {
            // Jika sudah ada, hapus dari wishlist.
            $wishlistItem->delete();
            return back()->with('success', 'Product removed from wishlist.');
        } else {
            // Jika belum ada, tambahkan ke wishlist.
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);
            return back()->with('success', 'Product added to wishlist!');
        }
    }
}