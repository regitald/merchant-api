<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with('merchant')->where('role_id','2')->get();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success list user admin',
            'data' => $user
        ]);
    }

    public function show($id)
    {
        $user = User::with('merchant')->where('role_id','2')->where('id',$id)->first();

        if(!$user){
            return response()->json(['status' => false,'code' => 404,'message' => 'User with given id not found'],404);
        }
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success list user admin',
            'data' => $user
        ]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'merchant_id' => 'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()],400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'role_id' => 2,
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'merchant_id' => $request->get('merchant_id'),
        ]);

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success created admin'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'merchant_id' => 'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()],400);
        }

        $user = User::where('id',$id)->where('role_id','2')->update([
            'name' => $request->get('name'),
            'merchant_id' => $request->get('merchant_id'),
        ]);

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success updated admin'
        ]);
    }

    public function destroy($id)
    {
        $user = User::where('id',$id)->where('role_id','2')->delete();

        if(!$user){
            return response()->json(['status' => false,'code' => 400,'message' => 'Failed to delete data'],400);
        }
        
        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success deleted admin'
        ]);
    }

    public function assign_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'merchant_id' => 'required|integer',
        ]);
        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()],400);
        }
        $updated = User::where('id',$request->get('user_id'))->where('role_id','2')->update([
            'merchant_id' => $request->get('merchant_id'),
        ]);

        if(!$updated){
            return response()->json(['status' => false,'code' => 400,'message' => 'data not update'],400);
        }

        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'Success asiign merchant to admin'
        ]);
    }
}
