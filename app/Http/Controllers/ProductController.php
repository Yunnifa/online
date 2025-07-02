<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk untuk tampilan publik.
     */
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan halaman manajemen produk untuk admin.
     */
    public function manage()
    {
        // Mengambil semua produk untuk ditampilkan di tabel manajemen.
        $products = Product::latest()->paginate(10);
        // Menggunakan notasi slash (/) untuk memanggil view.
        return view('admin/products/index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Menggunakan notasi slash (/) untuk memanggil view.
        return view('admin/products/create');
    }

    /**
     * Menyimpan produk baru ke dalam database.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input dari form.
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sizes' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Proses dan simpan gambar yang di-upload.
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // 3. Buat entri produk baru di database.
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'sizes' => $request->sizes,
            'image' => $imageName,
        ]);

        // 4. Alihkan kembali ke halaman manajemen dengan pesan sukses.
        return redirect()->route('admin.products.index')
                         ->with('success','Product created successfully.');
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        // Menggunakan notasi slash (/) untuk memanggil view.
        return view('admin/products/edit', compact('product'));
    }

    /**
     * Memperbarui produk yang ada di database.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi semua input dari form edit.
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sizes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar tidak wajib diisi saat update.
        ]);

        $input = $request->except('_token', '_method', 'image');

        // 2. Cek apakah ada gambar baru yang di-upload.
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada.
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
            // Simpan gambar baru.
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $input['image'] = $imageName;
        }

        // 3. Update data produk di database.
        $product->update($input);

        // 4. Alihkan kembali ke halaman manajemen dengan pesan sukses.
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        // 1. Hapus file gambar terkait dari server.
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }
        
        // 2. Hapus data produk dari database.
        $product->delete();
        
        // 3. Alihkan kembali ke halaman manajemen dengan pesan sukses.
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully');
    }
}
