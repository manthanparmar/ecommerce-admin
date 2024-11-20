<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{

    public function getList(Request $request){

        $reviews = DB::table('reviews')
        ->join('products', 'reviews.product_id', '=', 'products.id')
        ->join('users', 'reviews.user_id', '=', 'users.ID')
        ->select('reviews.*', 'products.name as product_name', 'users.username as username')
        ->latest('reviews.created_at') // Order by review creation date
        ->get();

    // Return the view with all reviews
    // return view('reviews.index', compact('reviews'));

        return view('review', ['reviewData' => $reviews]);
    }

    public function submitReview(Request $request)
    {
        // Insert the review into the reviews table
        try {
            DB::table('reviews')->insert([
                'product_id' => $request->productId,
                'user_id' => $request->userId,
                'rating' => $request->rating,
                'description' => $request->reviewText,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Review submitted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit review. Please try again later',
            ], 500);
        }
    }



}
