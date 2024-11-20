<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function create(Request $request){

        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');
        $products = new Products;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
    
            // Save the image path to the database or use it as needed
            $products->image_url = config('services.APP_URL') . '/storage/images/' . $imageName;
        }

        $products->name = $name;
        $products->description = $description;
        $products->price = $price;

        $products->save();

        return redirect('/products');
    }

    public function getList(Request $request){

        $returnProductsData = [];

        $products = Products::all();

        foreach ($products as $post) {
            $returnProductsData[] = [
                'ID' => $post->id,
                'name' => $post->name,
                'description' => $post->description,
                'price' => $post->price,  
                'image_url' => $post->image_url
            ];
        }

        return view('products', ['productsData' => $returnProductsData]);
    }

    public function getItem(Request $request, $addId){

        $products = Products::find($addId);

        $returnProductsData = [];

        $returnProductsData = [
            'ID' => $products->id,
            'name' => $products->name,
            'price' => $products->price,
            'description' => $products->description,
            'image_url' => $products->image_url,
        ];

        return view('editProducts',['productsData'=> $returnProductsData]);
    }

    public function edit(Request $request){

    
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');

        $products = Products::findOrFail($request->ID);

        $products->name = $name;
        $products->description = $description;
        $products->price = $price;

        if ($request->hasFile('image') && $products->image_url) {
            Storage::delete('public/images/' . basename($products->image_url));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
    
            // Save the image path to the database or use it as needed
            $products->image_url = config('services.APP_URL') . '/storage/images/' . $imageName;
        }

        $products->save();

        return redirect('/products');
    }

    public function deleteProducts($addId)
    {
        $products = Products::findOrFail($addId);

        // Delete the products from the database
        $products->delete();

        return redirect()->route('products')->with('success', 'Products deleted successfully');
    }


    public function getProducts(Request $request){

        $returnProductsData = [];

        $products = Products::all();
        if(!empty($products)){
            foreach ($products as $post) {
                $returnProductsData[] = [
                    'ID' => $post->id,
                    'name' => $post->name,
                    'description' => $post->description,
                    'price' => $post->price,  
                    'image_url' => $post->image_url
                ];
            }
        }

        return $returnProductsData;
    }

    public function getProductDetail(Request $request, $proId)
    {
        $userId = 1; // Replace with `auth()->id()` if authentication is implemented

        // Fetch product details
        $product = Products::find($proId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404); // Return error if product not found
        }

        // Fetch average rating from reviews table
        $averageRating = Review::where('product_id', $proId)
            ->avg('rating'); // Calculate average rating

        // Fetch logged-in user's review (if exists)
        $userReview = Review::where('product_id', $proId)
            ->where('user_id', $userId)
            ->select('rating', 'description')
            ->first(); // Fetch single review for the user

        $allreview = Review::leftjoin('users','reviews.user_id', '=', 'users.id')->where('product_id', $proId)->select('users.username','reviews.description AS reviewText', 'reviews.rating')->get();

        // Prepare the response data
        $returnProductsData = [
            'ID' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'image_url' => $product->image_url,
            'averageRating' => round($averageRating, 1) ?? 0, // Round to 1 decimal place, default to 0
            'userRating' => $userReview->rating ?? null, // User-specific rating
            'userReview' => $userReview->description ?? null, // User-specific review description
            'reviews' => $allreview ?? null, // User-specific review description
        ];

        return response()->json($returnProductsData);
    }

}
