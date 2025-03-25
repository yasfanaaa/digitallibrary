<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Reviews::all();

        return response()->json([
            'status' => 200,
            'message' => 'Reviews retrieved successfully.',
            'data' => $reviews
        ], 200);
    }

    public function store(Request $request)
    {
        
        // $request->validate([
        //     'book_id' => 'required|integer',
        //     'user_id' => 'required|integer',
        //     'rating' => 'required|integer|min:1|max:5',
        //     'comment' => 'nullable|string',
        // ]);

        
        $review = Reviews::create($request->all());

        try {
            // Store your data logic here
            return response()->json([
                'status' => 201,
                'message' => 'Review created successfully.',
                'data' => $review
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error storing API data: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
        
        
    }

    public function show($id)
    {
        $review = Reviews::find($id);

        if (!$review) {
            return response()->json([
                'status' => 404,
                'message' => 'Review not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Review retrieved successfully.',
            'data' => $review
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $review = Reviews::find($id);

        if (!$review) {
            return response()->json([
                'status' => 404,
                'message' => 'Review not found.',
                'data' => null
            ], 404);
        }

        // $request->validate([
        //     'book_id' => 'integer',
        //     'user_id' => 'integer',
        //     'rating' => 'integer|min:1|max:5',
        //     'comment' => 'nullable|string',
        // ]);

        $review->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Review updated successfully.',
            'data' => $review
        ], 200);
    }

    public function destroy($id)
    {
        $review = Reviews::find($id);

        if (!$review) {
            return response()->json([
                'status' => 404,
                'message' => 'Review not found.',
                'data' => $review
            ], 404);
        }

        $review->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Review deleted successfully.',
            'data' => null
        ], 200);
    }
}