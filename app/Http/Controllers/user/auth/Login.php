<?php

namespace App\Http\Controllers\user\auth;

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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = auth()->user();
            $success['token'] = $user->createToken($request->password . $request->email)->accessToken;
            $success['id'] = $user->id;
            return response()->json(["data"=>$success,  'massage' => 'successful','client'=>'user'], 200);
        }
        return response()->json(['erroe' => 'the password or email are not true',"massage" => "fault"]);
    }
}
