<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BooksController extends Controller
{
    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:books',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:9999',
        ]);

        try {
            $book = Books::create($request->all());

            return response()->json([
                'message' => 'Buku berhasil dibuat.',
                'book' => $book,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembuatan buku gagal', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Menampilkan semua buku
    public function index()
    {
        $books = Books::with(['user', 'category'])->get();
        return response()->json($books, Response::HTTP_OK);
    }

    // Menampilkan buku berdasarkan ID
    public function show($id)
    {
        $book = Books::with(['user', 'category'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($book, Response::HTTP_OK);
    }

    // Memperbarui buku
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255|unique:books,title,' . $id,
            'writer' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'publisher' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer|min:1000|max:9999',
        ]);

        try {
            $book = Books::findOrFail($id);
            $book->update($request->all());

            return response()->json([
                'message' => 'Buku berhasil diperbarui.',
                'book' => $book,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembaruan buku gagal', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Books::find($id);
        
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }
        
        $book->delete();
    
        return response()->json(['message' => 'Buku berhasil dihapus'], Response::HTTP_OK);
    }
}