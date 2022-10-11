<?php

namespace App\Http\Controllers;

use App\Models\Like as ModelsLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Like extends Controller
{

    public function index()
    {
        $user=Auth::id();
        if($user)
        {
        $lieks=ModelsLike::query()->where('user_id','=',$user)->with(['user' => function ($query) {
            $query->select('id', 'first_name','last_name');
        }])->with('car')->get();
        if($lieks)
        return response()->json(['data'=>$lieks,'message'=>'sucssful'],200);
        else
        return response()->json(['data'=>null,'message'=>'fult']);
        }
        else
        return response()->json(['error'=>'you are not auth','message'=>'fault']);
    }


    public function store(Request $request)
    {
       
        $vaildation=Validator::make($request->all(),[
            'user_id'=>['required','integer'],
            'car_id'=>['required','integer'],
        ]);


        if($vaildation->fails())
        {
            return response()->json(['message'=>"fault","error"=>$vaildation->errors()]);
        }
        
        $id=Auth::id();
        if(!$id){
            return response()->json(['message'=>'fault','error'=>"you are not auth"]);
        }
         try {
              ModelsLike::query()->create([
            'user_id'=>$id,
            'car_id'=>$request->car_id
        ]);
 } catch (\Exception $e) {
    return response()->json(['error'=>'you have error in db mabay the id user and car not uniqe']);
 }
        return response()->json(['message'=>'sucssful']);

    }



    public function destroy(int $id)
    {
        if($id<0)
        {
            return response()->json(['message'=>'fault','eroor'=>"the 'id' is not true"]);
        }
        $like=ModelsLike::query()->find($id);
        if(!$like)
        {
            return response()->json(['message'=>'fault','eroor'=>"not found like"]);
        }
        $user_id=Auth::id();
        if(!$user_id || $user_id!=$like->user_id){
            return response()->json(['message'=>'fault','error'=>"you are not auth"]);
        }

        try {
            $like->delete();
        } catch (\Throwable $th) {
            return response()->json(['message'=>'fault','error'=>$th->getMessage()],520);
        }

        return response()->json(['message'=>'sucssful']);

    }
}
