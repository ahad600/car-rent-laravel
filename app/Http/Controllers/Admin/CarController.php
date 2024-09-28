<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Car;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class CarController extends Controller
{
    public function carList(Request $request)
    {

        $query = Car::query();

        if ($request->has('car_type')) {
            $query->where('car_type', $request->car_type);
        }

        if ($request->has('model')) {
            $query->where('model', $request->model);
        }

        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('daily_rent_price')) {
            $query->where('daily_rent_price', $request->daily_rent_price);
        }
        $query->orderBy('id', 'DESC')->with('active_rent');

        return ResponseHelper::Out("", $query->get(), 200);
    }

    public function carGetById(Request $request, $id)
    {

        $query = Car::find($id);


        return ResponseHelper::Out("", $query, 200);
    }

    public function create(Request $request)
    {

        // Validate the file input
        // $request->validate([
        //     'name' => 'required',
        //     'brand' => 'required',
        //     'model' => 'required',
        //     'year' => 'required',
        //     'car_type' => 'required',
        //     'daily_rent_price' => 'required',
        //     'file' => 'required|mimes:jpg,jpeg,png', // Adjust the allowed mime types and max size as needed
        // ]);


        try {

            if ($request->file('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $request->file->move(public_path('images'), $filename);

                $request->merge(["image" => "images/" . $filename]);
            }
            $obj = Car::create($request->all());

            return ResponseHelper::Out("Car created successfully", $obj, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Car created fail", '', 409);
        }
    }

    public function update(Request $request, $id)
    {

        try {

            $obj = Car::find($id);

            if ($request->file('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $request->file->move(public_path('images'), $filename);

                $request->merge(["image" => "images/" . $filename]);

                $image_path = public_path($obj->image);


                if (File::exists($image_path)) {
                    $image_path = public_path($obj->image);

                    unlink($image_path);
                }
            }

            $obj->update($request->all());


            if ($obj) {
                return ResponseHelper::Out("Car update successfully", null, 200);
            }

            return ResponseHelper::Out("Car update fail", null, 400);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Car update fail", null, 400);
        }
    }






    public function delete(Request $request, $id)
    {

        try {
            $obj = Car::find($id);

            $image_path = public_path($obj->image);

            if (File::exists($image_path)) {

                unlink(public_path($obj->image));
            }

            $obj->delete();

            return ResponseHelper::Out("Car delete successfully", null, 204);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Car delete fail", $th->getMessage(), 400);
        }
    }
}
