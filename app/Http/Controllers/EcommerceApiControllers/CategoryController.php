<?php

namespace App\Http\Controllers\EcommerceApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EcommerceApiRequest\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index ()
    {
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
                'message' => 'No record found',
            ];
            return response()->json($data, 404);
        }
    }

    public function allcategory ()
    {
        $category = Category::where('status',0)->get();
                $data = [
                'status' => 200,
                'category'=> $category,
            ];
            return response()->json($data, 200);
        
    }

  public function store (CategoryRequest $request){
    $validatedData = $request->validated();
        $category = new Category;
       
    $category->slug = $validatedData['slug'];
    $category->name = $validatedData['name'];
    $category->description = $validatedData['description'];
    $category->meta_title = $validatedData['meta_title'];
    $category->meta_keyword = $validatedData['meta_keyword'];
    $category->meta_description = $validatedData['meta_description'];
    $category->status = isset($validatedData['status']) && $validatedData['status'] === true ? '1' : '0';
    $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category Added Sucessfully',
        ]);
  }

      public function show($id){
        $category = Category::find($id);
        if($category){
            $data = [
                'status' => 200,
                'category'=> $category
            ];
            return response()->json($data, 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such student Found'
            ], 404);
        }
    }

        public function edit ($id){
        $category = Category::find($id);
        if($category){
            $data = [
                'status' => 200,
                'category'=> $category
            ];
            return response()->json($data, 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such category Found'
            ], 404);
        }
    }
    public function update(CategoryRequest $request, int $id){
        $category = Category::find($id);
        $validatedData = $request->validated();
    
        if ($category) {
            $category->update($validatedData);
    
            $data = [
                'status' => 200,
                'message' => 'Category updated successfully',
                'category'=> $category
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No such category found',
            ];
            return response()->json($data, 404);
        }
    }
    
    public function destory($id){
        $category = Category::find($id);
        if($category){
                $category->delete();
            $data = [
                'status' => 200,
                'message' => 'student has been deleted successfully'
            ];

            return response()->json($data, 200);
    }else{
            $data = [
                'status' => 404,
                'message' => 'No such Student Found'
            ];
            return response()->json($data, 404);
            }
    }

}


