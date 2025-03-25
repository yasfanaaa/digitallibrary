<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        try {
            $category = Category::create($request->all());

            return response()->json([
                'message' => 'Kategori berhasil dibuat.',
                'category' => $category,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembuatan kategori gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan semua kategori
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    // Menampilkan kategori berdasarkan ID
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category, 200);
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $id,
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update($request->all());

            return response()->json([
                'message' => 'Kategori berhasil diperbarui.',
                'category' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembaruan kategori gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $category = Category::find($id);
        
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        
        $category->delete();
    
        return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
    }
}