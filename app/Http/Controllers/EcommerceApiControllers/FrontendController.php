<?php

namespace App\Http\Controllers\EcommerceApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function category ()
    {
        // $category = Category::where('status','0')->get();
        $category = Category::all();
        if ($category->count() > 0) {
            $data = [
                'status' => 200,
                'category'=> $category,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No category found',
            ];
            return response()->json($data, 404);
        }
    }


    public function product ($slug)
    {
        
        $category = Category::where('slug', $slug)-> where('status','0')->first();
        if ($category) {
            $product = Products::where('category_id', $category->id)->where('status',"0")->get();
            if($product->count() > 0){
                $data = [
                    'status' => 200,
                    'product_data'=>[
                        'product'=>$product,
                        'category'=>$category,
                    ],
                ];
                return response()->json($data, 200);
            }
            else {
                $data = [
                    'status' => 404,
                    'message' => 'No Products Available',
                ];
                return response()->json($data, 404);
            }
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No Products Available',
            ];
            return response()->json($data, 404);
        }
    }

    public function viewproduct($category_slug, $product_slug)
{
    $category = Category::where('slug', $category_slug)->where('status', '0')->first();
    
    if ($category) {
        $product = Products::where('category_id', $category->id)
                           ->where('slug', $product_slug)
                           ->where('status', "0")
                           ->first();

        if($product){
            $data = [
                'status' => 200,
                'product' => $product,
            ];

            return response()->json($data, 200);
        }
        else {
            $data = [
                'status' => 404,
                'message' => 'No Products Available',
            ];
            return response()->json($data, 404);
        }
    }
    else{
        $data = [
            'status' => 404,
            'message' => 'No such category found',
        ];
        return response()->json($data, 404);
    }
}


}    
