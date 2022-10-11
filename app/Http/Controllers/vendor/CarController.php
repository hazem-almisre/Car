<?php

namespace App\Http\Controllers\vendor;

use App\Models\Car;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CarResource;
use App\Http\Controllers\Controller;
use App\Models\CarName;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function carStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "model" => ['required','date'],
            "color" => "required|string",
            "description" => "string|required",
            "images.*"=>"image|required",
            "vendor_id" => "required|integer",
            ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        
        

        $image_url=[];
        if($request->images)
        for ($i=0;$i<count($request->images);$i++) {
            $image_name =  $request->images[$i]->getClientOriginalName();
            $image_name=time().".".$image_name;
            $image = $request->images[$i]->move('images', $image_name);
            $image_url[]=$image;
        }
        else
        return response()->json(['error'=>"you are not have images"]);
        $c=date_create($request->model);
        $request->model=date_format($c,'Y');

        $name_car=CarName::query()->where('name',$request->name)->first();
        
        if(!$name_car)
        return response()->json(['error'=>"the name car do not find","message"=>'fault']);
        
        if(Auth::guard('vendor')->id()!=$request->vendor_id)
        return response()->json(['error'=>'the vendor is not match with person has been add car']);
        
        $car = new Car;
        $car->name_id = $name_car->id;
        $car->model = $request->model;
        $car->color = $request->color;
        $car->description = $request->description;
        $car->vendor_id = $request->vendor_id;

        if ($car->save()) {
            foreach ($image_url as $value) {
                 Image::query()->create(
                    [
                        "image_url"=>$value,
                        "car_id"=>$car->id
                    ]
                    );
            }
            return response()->json(
                [
                    "message" => "All cars data are Validated and saved",
                    "data" => new CarResource($car)
                ],
                200
            );
        }
    }

    public function carShow($id) {


        // $car =DB::select("select distinct model,color,image_url,first_name,last_name,name from cars c  inner join images im on(im.car_id=c.id)
        // inner join vendors ve on(ve.id=c.vendor_id) inner join car_names cn on(cn.id=c.name_id) WHERE c.id = $id");
         $car=Car::query()->with('vendor',function($var){
            $var->select('id','first_name','last_name');
         })->with('carName',function($var){
            $var->select('id','name');
        })->find($id);
        if(!$car)
        return response()->json(['error'=>'the car not found','message'=>'fault']);
        $image = Image::query()->select('image_url')->where('car_id',$id)->get();
        if($image)
        $car['image']=$image;

        return response()->json(
            [
                "message" => "The Car with the id". $id ."data is :",
                "data :" =>new CarResource($car)
                    ],
            200);
        }



        public function update(Request $request, $id)
        {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "model" => ['required','date'],
            "color" => "required|string",
            "description" => "string|required",
            "images.*"=>"image|required",
            "vendor_id" => "required|integer",
            ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $car = Car::query()->findOrFail($id);
        $images=$car->iamages;
        if($images)
        foreach ($images as $value) {
              if (!is_null($value->image_url) && file_exists($value->image_url))
            unlink($value->image_url);
        }
        
        Image::query()->where('car_id','=',$id)->delete();
        
        $image_url=[];
        for ($i=0;$i<count($request->images);$i++) {
            $image_name =  $request->images[$i]->getClientOriginalName();
            $image_name=time().".".$image_name;
            $image = $request->images[$i]->move('images', $image_name);
            $image_url[]=$image;
        }
        $c=date_create($request->model);
        $request->model=date_format($c,'Y');

        if(Auth::guard('vendor')->id()!=$request->vendor_id)
        return response()->json(['error'=>'the vendor is not match with person has been update']);
        
        $name_car=CarName::query()->where('name',$request->name)->first();
        if(!$name_car)
        return "name car do not find";
        $car->name_id = $name_car->id;
        $car->model = $request->model;
        $car->color = $request->color;
        $car->description = $request->description;

        $car->vendor_id = $request->vendor_id;

        if ($car->save()) {
            foreach ($image_url as $value) {
                 Image::query()->create(
                    [
                        "image_url"=>$value,
                        "car_id"=>$car->id
                    ]
                    );
            }
            return response()->json(
                [
                    "message" => "All cars data are Validated and saved",
                    "data" => [new CarResource($car)]
                ],
                200
            );
        }
        else{
            return response()->json(['error'=>'car data not save in DB','message'=>'fault']);
        }
        }
    public function destroy(Request $request,$id)
    {
        
            $validator = Validator::make($request->all(), [
            "vendor_id" => "required|integer",
            ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        
        if(Auth::guard('vendor')->id()!=$request->vendor_id)
        return response()->json(['error'=>'the vendor is not match with person has been delete']);
        
        $car = Car::findOrFail($id);
        $images=$car->iamages;
        foreach ($images as $value) {
            if (!is_null($value->image_url)&& file_exists($value->image_url))
            unlink($value->image_url);
        }
        if ($car->delete()) {
            return response()->json(
                [
                    "message" => "The Car Deleted Successfully",
                    "data :" => new CarResource($car)
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "fault",
                    "error :" => "the car hasn't been deleted"
                ],
                200
            );
        }
    }




}
