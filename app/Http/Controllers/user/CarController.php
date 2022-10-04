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

        $cars = Car::paginate(8);


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
        return Car::where("id","like","%".$id."%")->get();
    }

    public function nameSearchCar($name)
    {
        //
        return Car::where("name", "like", "%" . $name . "%")->get();
    }

    public function modelSearchCar($model)
    {
        //
        return Car::where("model", "like", "%" . $model . "%")->get();
    }

    public function colorSearchCar($color)
    {
        //
        return Car::where("color", "like", "%" . $color . "%")->get();
    }

    public function descriptionSearchCar($description)
    {
        //
        return Car::where("description", "like", "%" . $description . "%")->get();
    }

}
