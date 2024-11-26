<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsCategory;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    //
    // Menampilkan daftar kategori
    public function index()
    {
        $newscategories = NewsCategory::paginate(10);

        return view('newscategories.index', compact('newscategories'));
    }

    // Menampilkan form untuk membuat kategori baru
    public function create()
    {
        return view('newscategories.add');
    }

    // Menyimpan kategori baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:news_categories',
        ]);

        // Menyimpan kategori ke dalam database
        NewsCategory::create($validated);

        return redirect()->route('news-categories.index')->with('success', 'Kategori Berita berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit($slug)
    {
        $newscategory = NewsCategory::where('slug', $slug)->firstOrFail();

        return view('newscategories.show', compact('newscategory'));
    }

    // Memperbarui kategori yang ada di database
    public function update(Request $request, $slug)
    {
        // Validasi input - memastikan nama kategori unik dan valid
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name,' . $slug . ',slug',  // Validasi nama kategori, pengecualian untuk kategori yang sedang diperbarui
        ]);

        // Cari kategori berdasarkan slug
        $category = NewsCategory::where('slug', $slug)->firstOrFail();

        // Perbarui nama kategori
        $category->name = $validated['name'];

        // Generate slug baru berdasarkan nama kategori yang diperbarui
        $category->slug = Str::slug($validated['name']);

        // Cek apakah slug yang baru sudah ada
        if (NewsCategory::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
            // Jika slug sudah ada, tambahkan angka untuk menghindari duplikasi
            $category->slug = $category->slug . '-' . rand(1, 1000);
        }

        // Simpan perubahan kategori
        $category->save();

        // Redirect ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('news-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }


    // Menghapus kategori dari database
    public function destroy($slug)
    {
        // Cari kategori berdasarkan slug
        $newscategory = NewsCategory::where('slug', $slug)->firstOrFail();

        // Hapus kategori
        $newscategory->delete();

        return redirect()->route('news-categories.index')->with('success', 'Kategori Berita berhasil dihapus.');
    }
}
