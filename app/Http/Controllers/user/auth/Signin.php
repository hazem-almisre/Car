<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator ;

class Signin extends Controller
{
    public function signin($request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password',
            "phone_number" => 'required|string|unique:users,phone_number'
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
        $user = User::create($input);
        $success['token'] = $user->createToken($request->password . $request->email)->accessToken;
        $success['id'] = $user->id;
        return response()->json(["data"=>$success,  'massage' => 'successful','client'=>'user'], 200);    # code...
    }
}
