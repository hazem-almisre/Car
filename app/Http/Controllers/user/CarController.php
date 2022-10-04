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

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->paginate(8);


        return response()->json(
            [
                "message" => "All Cars data ",
                "data :" => CarResource::collection($cars)
            ],
            200
        );
    }
            //  Car search methods and functions :

    public function idSearchCar($id)
    {
        //
        return Car::where("id","=",$id)->with('iamages')->with('carName',function($var){
            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->get();
    }


    public function nameSearchCar($name)
    {
        //update
        $GLOBALS['name']=$name;
        return Car::query()->whereHas('carName',function($var){

            $var->where("name", "like", "%" .  $GLOBALS['name'] . "%");
        }
        )->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();
    }

    public function modelSearchCar($model)
    {
        //
        return Car::where("model", "like", "%" . $model . "%")->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();
    }

    public function colorSearchCar($color)
    {
        //
        return Car::where("color", "like", "%" . $color . "%")->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();
    }

    public function descriptionSearchCar($description)
    {
        //
        return Car::where("description", "like", "%" . $description . "%")->with('carName',function($var){

            $var->select('id','name');
        })->with('vendor',function($var){

            $var->select('id','first_name','last_name');
        })->with('iamages')->get();
    }

}
