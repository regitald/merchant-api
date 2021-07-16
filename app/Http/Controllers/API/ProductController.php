<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('categories')->get();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success list products',
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
            'name' => 'required|string|max:255',
            'merchant_code' => 'required|string',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'category' => 'required|array',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()]);
        }

        $product = Product::create([
            'name' => $request->get('name'),
            'merchant_code' => $request->get('merchant_code'),
            'stock' => $request->get('stock'),
            'description' => $request->get('description')
        ]);

        if(count($request->category)){
            foreach ($request->category as $key) {
                $array['product_code'] = $product->code;
                $array['category_code'] = $key;
                $payload[] = $array;
            }            
            $product_category = ProductCategory::insert($payload);
        }

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success created product'
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
        $product = Product::with('categories')->where('id',$id)->first();

        if(!$product){
            return response()->json(['status' => false,'code' => 404,'message' => 'Product with given id not found']);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success detail product',
            'data' => $product
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
            'stock' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()]);
        }

        $product = Product::with('categories')->where('id',$id)->first();

        if(!$product){
            return response()->json(['status' => false,'code' => 404,'message' => 'Product with given id not found']);
        }

        $update = Product::where('id',$id)->update([
            'name' => $request->get('name'),
            'stock' => $request->get('stock'),
            'description' => $request->get('description')
        ]);

        $delete_product_category = ProductCategory::where('product_code',$product->code)->delete();

        if(count($request->category)){
            foreach ($request->category as $key) {
                $array['product_code'] = $product->code;
                $array['category_code'] = $key;
                $payload[] = $array;
            }            
            $product_category = ProductCategory::insert($payload);
        }

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success updated product'
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
        $product = Product::with('categories')->where('id',$id)->delete();

        if(!$product){
            return response()->json(['status' => false,'code' => 404,'message' => 'Failed to delete data']);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success deleted product'
        ]);
    }
}
