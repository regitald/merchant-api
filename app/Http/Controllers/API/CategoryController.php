<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::get();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success list categories',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|required|max:255',
            'description' => 'nullable|string',
            'merchant_code' => 'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()->toJson()]);
        }

        $product = Category::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'merchant_code' => $request->get('merchant_code'),
        ]);

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success created category'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id',$id)->first();

        if(!$category){
            return response()->json(['status' => false,'code' => 404,'message' => 'Category with given id not found']);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success detail category',
            'data' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()->toJson()]);
        }

        $product = Category::where('id',$id)->update([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success updated category'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id',$id)->delete();

        if(!$category){
            return response()->json(['status' => false,'code' => 404,'message' => 'Failed to delete data']);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success deleted category'
        ]);
    }
}
