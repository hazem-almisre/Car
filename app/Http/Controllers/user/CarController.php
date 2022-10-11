<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\CarResource;



use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class CarController extends Controller
{

    public function index()
    {
        //
        //$input = Car::query()->get();
        //return response()->json($input,Response::HTTP_OK);

        $cars = Car::query()->with('carName',function($var){
            $var->get('name');
        })->with('vendor',function($var){
            $var->select('id','first_name','last_name');
        })->with('iamages')->paginate(2);

        if($cars)
        return response()->json(
            [
                "message" => "All Cars data ",
                "data" => $cars
            ],
            200
        );
        else
        {
            return response()->json(['error'=>'find error in get cars','message'=>'fault']);
        }
    }
            //  Car search methods and functions :

    public function idSearchCar($id)
    {
        //
        $car= Car::where("id","=",$id)->with('iamages')->with('carName',function($var){
            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->get();

        if($car)
        return response()->json(['message'=>'succful','data'=>$car]);
        else
        return response()->json(['error'=>'car not found','message'=>'fault']);

    }


    public function nameSearchCar($name)
    {
        //update
        $GLOBALS['name']=$name;
        $car =Car::query()->whereHas('carName',function($var){
            $var->where("name", "like", "%" .  $GLOBALS['name'] . "%");
        }
        )->with('carName',function($var){
            $var->select('id','name');
        })->with('vendor',function($var){
            $var->select('id','first_name','last_name');
        })->with('iamages')->get();

        if($car)
        return response()->json(['message'=>'succful','data'=>$car]);
        else
        return response()->json(['error'=>'car not found','message'=>'fault']);
    }

    public function modelSearchCar($model)
    {
        //
        $car= Car::where("model", "like", "%" . $model . "%")->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();

        if($car)
        return response()->json(['message'=>'succful','data'=>$car]);
        else
        return response()->json(['error'=>'car not found','message'=>'fault']);
    }

    public function colorSearchCar($color)
    {
        //
        $car= Car::where("color", "like", "%" . $color . "%")->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();

        if($car)
        return response()->json(['message'=>'succful','data'=>$car]);
        else
        return response()->json(['error'=>'car not found','message'=>'fault']);
    }

    public function descriptionSearchCar($description)
    {
        //
        $car= Car::where("description", "like", "%" . $description . "%")->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();

        if($car)
        return response()->json(['message'=>'succful','data'=>$car]);
        else
        return response()->json(['error'=>'car not found','message'=>'fault']);
    }

}
