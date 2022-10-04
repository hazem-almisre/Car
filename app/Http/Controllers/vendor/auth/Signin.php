<?php

namespace App\Http\Controllers\vendor\auth;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator ;

class Signin extends Controller
{
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|string|unique:vendors,email',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password',
            "phone" => 'required|string|unique:vendors,phone'
        ], [
            'name.required' => 'you do not have name '
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
                ,"massage" => "fault"]);
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $user = Vendor::create($input);
        $success['token'] = $user->createToken($request->password . $request->email)->accessToken;
        $success['id'] = $user->id;
        return response()->json(["data"=>$success,  'massage' => 'successful','client'=>'user'], 200);    # code...
    }
}
