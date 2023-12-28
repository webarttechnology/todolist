<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\{Category};

class CategoryManageController extends Controller
{
    //

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required' => 'Category Name is required'
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->messages()->first();
            return response()->json(['success' => 0, 'statusCode' => 422, 'msg' => $responseArr]);
        }

        if(Category::whereName($request->name)->exists()){
            return response()->json(['success' => 0, 'statusCode' => 403, 'msg' => 'This Category Already Exists']);
        }else{
            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json(['success' => 1, 'statusCode' => 200, 'msg' => 'Success', 'data' => $category]);
        }
    }

    public function list(){
        $category = Category::orderBy('id', 'desc')->get();
        return response()->json(['success' => 1, 'statusCode' => 200, 'msg' => 'Success', 'data' => $category]);
    }

    public function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
        ],[
            'name.required' => 'Category Name is required',
            'category_id.required' => 'Category Id is required'
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->messages()->first();
            return response()->json(['success' => 0, 'statusCode' => 422, 'msg' => $responseArr]);
        }

        if(Category::whereName($request->name)->where('id', '!=', $request->category_id)->exists()){
            return response()->json(['success' => 0, 'statusCode' => 403, 'msg' => 'Category Exists']);
        }else{
            Category::where('id', $request->category_id)->update([
                'name' => $request->name,
                'description' => ($request->description == null) ? ((Category::where('id', $request->category_id)->first())->description) : $request->description,
            ]);

            $category = Category::where('id', $request->category_id)->first();
            return response()->json(['success' => 1, 'statusCode' => 200, 'msg' => 'Success', 'data' => $category]);
        }
    }

    public function delete($category_id){
        Category::find($category_id)->delete();
        return response()->json(['success' => 1, 'statusCode' => 200, 'msg' => 'Success']);
    }

    public function individual_list($category_id){
           $category = Category::whereId($category_id)->first();
           return response()->json(['success' => 1, 'statusCode' => 200, 'msg' => 'Success', 'data' => $category]);
    }
}