<?php

namespace App\Http\Controllers\EcommerceApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EcommerceApiRequest\ProductRequest;
use App\Http\Requests\EcommerceApiRequest\UpdateProductRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index ()
    {
        $product = Products::paginate(10);
        if ($product->count() > 0) {
            $data = [
                'status' => 200,
                'products'=> $product,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No record found',
            ];
            return response()->json($data, 404);
        }
    }

    public function store (ProductRequest $request){
        $validatedData = $request->validated();
            $product = new Products;
           
        $product->category_id = $validatedData['category_id'];
        $product->slug = $validatedData['slug'];
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->sellingPrice = $validatedData['sellingPrice'];
        $product->originalPrice = $validatedData['originalPrice'];
        $product->brand = $validatedData['brand'];
        $product->quantity = $validatedData['quantity'];

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
        
            // Check if the file is an image
            if ($file->isValid() && in_array($file->getClientMimeType(), ['image/png', 'image/jpeg', 'image/gif'])) {
                $filename = time() . '.' . $file->guessExtension();
                $path = $file->storeAs('public/uploads/product', $filename);
                $product->image = str_replace('public/', '', $path);
            
            }
        }
        
        // if($request->hasFile('image'))
        // {
        //     $file = $validatedData->file('image');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time().' . '.$extension;
        //     $file->move('uploads/product/', $filename);
        //     $product ->image = 'uploads/product/'.$filename;
        // }
        $product->feature = $validatedData['feature'] ?? false;
        $product->status = $validatedData['status'] ?? false;
        $product->popular = $validatedData['popular'] ?? false;
        
        
        $product->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Products Added Sucessfully',
            ]);
      }
     
      public function edit ($id){
        $product = Products::find($id);

        if($product){
            $data = [
                'status' => 200,
                'products'=> $product
            ];
            return response()->json($data, 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such category Found'
            ], 404);
        }
    }


    
    public function update(UpdateProductRequest $request, int $id){
        $product = Products::findOrFail($id);
        $validatedData = $request->validated();
    
        if ($product) {
            $product->category_id = $validatedData['category_id'];
            $product->slug = $validatedData['slug'];
            $product->name = $validatedData['name'];
            $product->description = $validatedData['description'];
            $product->sellingPrice = $validatedData['sellingPrice'];
            $product->originalPrice = $validatedData['originalPrice'];
            $product->brand = $validatedData['brand'];
            $product->quantity = $validatedData['quantity'];
            $product->feature = $validatedData['feature'] ?? false;
            $product->status = $validatedData['status'] ?? false;
            $product->popular = $validatedData['popular'] ?? false;
            
            
    
            if($request->hasFile('image')) {
                $file = $request->file('image');
    
                // Delete the old image if it exists
                $oldImagePath = 'public/uploads/product/' . $product->image;
                if(File::exists($oldImagePath)){
                    File::delete($oldImagePath);
                }
    
                // Check if the file is an image
                if ($file->isValid() && in_array($file->getClientMimeType(), ['image/png', 'image/jpeg', 'image/gif'])) {
                    $filename = time() . '.' . $file->guessExtension();
                    $path = $file->storeAs('public/uploads/product', $filename);
                    $product->image = str_replace('public/', '', $path);
                }
            }
    
            $product->save();
    
            $data = [
                'status' => 200,
                'message' => 'Product updated successfully',
                'products'=> $product
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No such product found',
            ];
            return response()->json($data, 404);
        }
    }
    
    
}
