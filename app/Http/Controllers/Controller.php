<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\CarResource;



use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    // Car Controller

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

//////////////////////////////////////////////////////////////////////////////////////
//                   Vendor Methods and Functions :
//////////////////////////////////////////////////////////////////////////////////////

public function carStore(Request $request)
    {


        $validator = Validator::make($request->all(), [

            "name" => "required",
            "model" => "required",
            "color" => "required",
         // "description"    => "",

            "vendor_id"    => "required | integer",
            ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $car = new Car;
        $car->name = $request->name;
        $car->model = $request->model;
        $car->color = $request->color;
        $car->description = $request->description;

        $car->vendor_id = $request->vendor_id;

        if ($car->save()) {

            return response()->json(
                [
                    "message" => "All cars data are Validated and saved",
                    "data :" => new CarResource($car)
                ],
                200
            );
        }
    }

    public function carShow($id) {


         $car = Car::findOrFail($id);

        return response()->json(
            [
                "message" => "The Car with the id $id data is :",
                "data :" =>new CarResource($car)
                    ],
            200);
        }



        public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [

            "name" => "required",
            "model" => "required",
            "color" => "required",
         // "description"    => "",

            "vendor_id"    => "required | integer",
            ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $car = new Car;
        $car->name = $request->name;
        $car->model = $request->model;
        $car->color = $request->color;
        $car->description = $request->description;

        $car->vendor_id = $request->vendor_id;

        if ($car->save()) {

            return response()->json(
                [
                    "message" => "All cars data are Validated and saved",
                    "data :" => new CarResource($car)
                ],
                200
            );
        }

    }

    public function destroy($id)
    {
        //
        $car = Car::findOrFail($id);

        if ($car->delete()) {

            return response()->json(
                [
                    "message" => "The Car Deleted Successfully",
                    "data :" => new CarResource($car)
                ],
                200
            );
        } else {
            return "the car hasn't been deleted";
        }
    }




}
