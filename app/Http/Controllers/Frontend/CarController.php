<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Car;
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
}
