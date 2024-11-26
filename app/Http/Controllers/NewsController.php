<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Menampilkan daftar berita
    public function index()
    {
        // Ambil semua berita yang statusnya "published"
        $news = News::with('newscategory')->paginate(10);

        return view('news.index', compact('news'));
    }

    // Menampilkan detail berita berdasarkan slug
    public function show($slug)
    {
        // Cari artikel berdasarkan slug
        $news = News::where('slug', $slug)->firstOrFail();

        return view('news.show', compact('news'));
    }

    public function create()
    {
        // Ambil semua kategori
        $newscategories = NewsCategory::all();
        $newscategoryoptions = $newscategories->pluck('name', 'id');

        return view('news.add', compact('newscategoryoptions'));
    }

    // Menyimpan berita baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255|unique:news,title',
            'content' => 'required|string',
            'news_category_id' => 'required|exists:news_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',    
        ]);

        // Membuat slug dari judul
        $slug = Str::slug($request->title);

        // Menyimpan berita ke dalam database
        $news = News::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'news_category_id' => $request->news_category_id,
            'status' => 'draft',  // Default status
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
        
            // Menyimpan gambar dengan nama unik (menggunakan timestamp)
            $imageName = time() . '.' . $image->getClientOriginalExtension();
        
            // Simpan file di direktori 'public/images'
            $image->storeAs('public/images', $imageName);
        
            // Simpan nama file (tanpa 'public/') ke database
            $news->image = 'images/' . $imageName;
            $news->save();
        }        

        return redirect()->route('news.index')->with('success', 'Berita berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit berita
    public function edit($slug)
    {
        // Cari artikel berdasarkan slug
        $news = News::where('slug', $slug)->firstOrFail();
        $newscategories = NewsCategory::all();
        $newscategoryoptions = $newscategories->pluck('name', 'id');

        return view('news.edit', compact('news', 'newscategoryoptions'));
    }

    // Memperbarui berita yang ada di database
    public function update(Request $request, $slug)
    {
        // Validasi input
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'news_category_id' => 'required|exists:news_categories,id',
            'status'      => 'required|in:draft,published',
        ]);

        // Cari artikel berdasarkan slug
        $news = News::where('slug', $slug)->firstOrFail();

        // Update file gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if ($news->image && Storage::exists('public/' . $news->image)) {
                Storage::delete('public/' . $news->image);
            }

            // Simpan file baru
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);

            // Update nama file di database
            $news->image = 'images/' . $imageName;
        }

        $slugnews = Str::slug($request->title);
        
        // Update data lainnya
        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'news_category_id' => $request->news_category_id,
            'slug' => $slugnews,
            'status' => $request->status,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    // Menghapus berita dari database
    public function destroy($slug)
    {
        // Cari artikel berdasarkan slug
        $news = News::where('slug', $slug)->firstOrFail();

        // Hapus artikel
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }

}
