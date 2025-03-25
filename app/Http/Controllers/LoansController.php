<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    // Menyimpan pinjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|string|max:255',
        ]);

        try {
            $loan = Loans::create($request->all());

            return response()->json([
                'message' => 'Pinjaman berhasil dibuat.',
                'loan' => $loan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembuatan pinjaman gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan semua pinjaman
    public function index()
    {
        $loans = Loans::with(['book', 'user'])->get();
        return response()->json($loans, 200);
    }

    // Menampilkan pinjaman berdasarkan ID
    public function show($id)
    {
        $loan = Loans::with(['book', 'user'])->findOrFail($id);
        return response()->json($loan, 200);
    }

    // Memperbarui pinjaman
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'sometimes|exists:books,id',
            'user_id' => 'sometimes|exists:users,id',
            'loan_date' => 'sometimes|date',
            'return_date' => 'sometimes|date|after_or_equal:loan_date',
            'status' => 'sometimes|string|max:255',
        ]);

        try {
            $loan = Loans::findOrFail($id);
            $loan->update($request->all());

            return response()->json([
                'message' => 'Pinjaman berhasil diperbarui.',
                'loan' => $loan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembaruan pinjaman gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // Menghapus pinjaman
    public function destroy($id)
    {
        $loan = Loans::find($id);
        
        if (!$loan) {
            return response()->json(['message' => 'Pinjaman tidak ditemukan'], 404);
        }
        
        $loan->delete();
    
        return response()->json(['message' => 'Pinjaman berhasil dihapus'], 200);
    }
}