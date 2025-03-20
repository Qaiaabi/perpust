<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function category_page(Request $request)
    {
        $data = Category::orderBy('created_at', 'desc')->get(); // Urutkan dari yang terbaru
        return view('admin.category', compact('data'));
    }
    public function add_category(Request $request)
    {
        // Validasi input
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        // Periksa apakah kategori sudah ada (case-insensitive)
        $existingCategory = Category::whereRaw('LOWER(cat_title) = ?', [strtolower($request->category)])->first();

        if ($existingCategory) {
            return redirect()->back()->with('error', 'Kategori sudah ada!');
        }

        // Simpan kategori jika belum ada
        $data = new Category;
        $data->cat_title = $request->category;
        $data->save();

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    //fungsi untuk menghapus kategori
    public function cat_delete($id)
    {
        $data = Category::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    }
    public function edit($id) {
        $category = Category::findOrFail($id); // Cari kategori berdasarkan ID
        return view('admin.edit_category', compact('category'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);
    
        $category = Category::findOrFail($id);
        $category->cat_title = $request->category;
        $category->save();
    
        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui!');
    }
    
    
}
