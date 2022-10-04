<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Validation\Rule;
use App\Http\Resources\CarResource;



use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarController extends Controller
{
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
