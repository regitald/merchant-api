<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Merchant::get();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success list merchants',
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
            'description' => 'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()->toJson()]);
        }

        $merchant = Merchant::create([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success created merchant'
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
        $merchant = Merchant::where('id',$id)->first();

        if(!$merchant){
            return response()->json(['status' => false,'code' => 404,'message' => 'Merchant with given id not found']);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success detail merchant',
            'data' => $merchant
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

        $merchant = Merchant::where('id',$id)->update([
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success updated merchant'
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
        $merchant = Merchant::where('id',$id)->delete();

        if(!$merchant){
            return response()->json(['status' => false,'code' => 404,'message' => 'Failed to delete data']);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success deleted merchant'
        ]);
    }
}
