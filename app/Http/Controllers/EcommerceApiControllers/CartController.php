<?php

namespace App\Http\Controllers\EcommerceApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addtocart (Request $request){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
            $product_quantity = $request->product_quantity;
            
            $productcheck = Products::where('id', $product_id)->first();

            if($productcheck)
            {
                if(Cart::where('product_id',$product_id)->where('user_id',$user_id )->exists())
                {
                    return response()->json([
                        'status' => 409,
                        'message' => $productcheck->name.' Already added to cart '
                    ], 409);   
                }
                else
                {
                    $cartitem = new Cart;
                    $cartitem->user_id = $user_id;
                    $cartitem->product_id = $product_id;
                    $cartitem->product_quantity = $product_quantity;
                    $cartitem->save();           

                    return response()->json([
                        'status' => 201,
                        'message' => 'Added to cart '
                    ], 201);
                }
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product Not Found'
                ], 404);
            }
        }
        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Login to add to cart'
            ], 401);
        }
    }


    public function viewcart ()
    {
        if(auth('sanctum')->check()){
             $user_id = auth('sanctum')->user()->id;
             $cartitems = Cart::where('user_id',$user_id)->get();
             return response()->json([
                'status' => 200,
                'cart'=>  $cartitems,
            ], 201);
        }else{
            
                return response()->json([
                    'status' => 401,
                    'message' => 'Login to View to cart Data'
                ], 401);
            
        }
    }

    public function updatequantity($cart_id, $scope)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();
           
                if ($scope == "increament") {
                    // Increase quantity by 1
                    $cartitem->product_quantity += 1;
                } else if ($scope == "decreament") {
                    // Decrease quantity by 1
                        $cartitem->product_quantity -= 1;                  
                }
                $cartitem->update();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Quantity updated',
                ], 201);
            
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ], 401);
        }
    }

    public function deletecartitem ($cart_id){
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $cartitem = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();
            if($cartitem){
                $cartitem->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'cart item remove successfully',
                ], 200);

            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Cart item not found',
                ], 400);
            }

        }else{
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ], 401);
        }

    }
    
    
}
