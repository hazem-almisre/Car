<?php

namespace App\Http\Controllers\vendor\auth;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ], );
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
                ,"massage" => "fault"]);
        }
        $vendor = Vendor::query()->where('email', $request->email)->first();

        if ($vendor && Hash::check($request->password, $vendor->password)) {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $success['token'] = $vendor->createToken($request->password . $request->email)->accessToken;
            $success['id'] = $vendor->id;
            return response()->json(["data"=>$success,  'massage' => 'successful','client'=>'vendor'], 200);
        }

        return response()->json(['error' => 'the password or email are not true','message'=>'fault']);
    }
}
