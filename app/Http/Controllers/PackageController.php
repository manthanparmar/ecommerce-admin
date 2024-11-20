<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    public function login()
    {
        return view('login');

    }
    public function loginSubmit(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
    
        // Authenticate user based on username and password
        $user = (new User)->authenticate($username, $password);
    
        if ($user) {
            // Check if the user role is 'admin'
            if ($user->role === 'admin') {
                // Prepare session data for authenticated admin
                $sessionData = [
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role, // Optional, in case you want to use it later
                ];
    
                // Store session data
                Session::put('userSession', $sessionData);
    
                // Redirect to admin dashboard or relevant page
                return redirect("products");
            } else {
                // User is authenticated but not an admin
                return redirect()->back()->with('error', 'Access denied. Admins only.');
            }
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }
    

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/login');
    }

    public function insertToCart(Request $request)
    {
       
        if(!isset($request->user_id) || empty($request->user_id)){
            return response()->json(['error' => 201,'message' => 'user_id required!']);
        } else if(!isset($request->product_id) || empty($request->product_id)){
            return response()->json(['error' => 201,'message' => 'product_id required!']);
        }

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', $request->user_id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            // Update quantity if the product is already in the cart
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create a new cart item
            Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully.']);
    }

    public function getCartData(Request $request, $userId)
    {
        if (empty($userId)) {
            return response()->json(['error' => 201, 'message' => 'user_id required!']);
        }
    
        // Perform the join between the cart and product tables
        $cartItems = DB::table('cart') // Assuming 'cart' is your cart table name
            ->join('products', 'cart.product_id', '=', 'products.id') // Join with the products table
            ->where('cart.user_id', $userId) // Filter by user_id
            ->select(
                'cart.id as cart_id',
                'cart.product_id',
                'cart.quantity',
                'products.name',
                'products.price',
                'products.image_url'
            )
            ->get();
    
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'No items found in the cart']);
        }
    
        return response()->json($cartItems);
    }

    public function updateCart(Request $request, $cartId)
    {
       
        $cartItem = Cart::find($cartId);

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found!'], 404);
        }
        if($request->input('quantity') == 0 || $request->input('quantity') == '0')
        {
            // Delete the cart from the database
            $cartItem->delete();
    
        } else {
            // Update the cart item quantity
           $cartItem->quantity = $request->input('quantity');
           $cartItem->save();
        }

        return response()->json(['message' => 'Cart item updated successfully!']);
    }

    
    
}
