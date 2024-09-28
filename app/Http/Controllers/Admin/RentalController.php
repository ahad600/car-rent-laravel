<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helper\ResponseHelper;
use App\Models\Admin\Car;

class RentalController extends Controller
{
    public function rentalList(Request $request)
    {

        $query = Rental::select(
            'rentals.id',
            'users.name as customer_name',
            'cars.name',
            'cars.brand',
            'total_cost',
            'status',
            'start_date',
            'end_date'
        )
            ->join('users', 'users.id', '=', 'user_id')
            ->join('cars', 'cars.id', '=', 'car_id')->orderBy('id', 'DESC');

        return ResponseHelper::Out("", $query->get(), 200);
    }

    public function rentalHistory(Request $request, $id)
    {

        $query = Rental::select(
            'rentals.id',
            'cars.name',
            'rentals.status',
        )
            ->join('cars', 'cars.id', '=', 'car_id')

            ->where('user_id', $id)
            ->orderBy('id', 'DESC');

        return ResponseHelper::Out("", $query->get(), 200);
    }

    public function rentalsGetById(Request $request, $id)
    {

        $query = Rental::select(
            'rentals.id',
            'users.name as customer_name',
            'cars.name',
            'cars.brand',
            'total_cost',
            'status',
            'start_date',
            'end_date'
        )
            ->join('users', 'users.id', '=', 'user_id')
            ->join('cars', 'cars.id', '=', 'car_id')->find($id);

        return ResponseHelper::Out("", $query, 200);
    }


    public function create(Request $request)
    {

        try {

            $user_id = $request->header('id');

            $car_id = $request->car_id;

            $start_date = $request->start_date;

            $end_date = $request->end_date;

            $startDate = Carbon::parse($start_date);

            $endDate = Carbon::parse($end_date);

            $car_rental_count_ongoing = Rental::where("car_id", $car_id)
                ->where("status", "Ongoing")
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->where(function ($q) use ($start_date, $end_date) {
                        $q->whereDate('start_date', '<=', $end_date)
                            ->whereDate('end_date', '>=', $start_date);
                    });
                })
                ->count();


            if ($car_rental_count_ongoing != 0) {

                return ResponseHelper::Out("This car already Ongoing", null, 401);
            }

            if ($car_id) {
                $car_obj = Car::where('id', $car_id)->where('availability', 1)->first();

                if (!$car_obj) {

                    return ResponseHelper::Out("Rental car is not available", null, 404);
                }

                $daysDifference = $startDate->diffInDays($endDate);

                $total_cost = $car_obj->daily_rent_price * $daysDifference;

                $request->merge(['car_id' => $car_id, "total_cost" => $total_cost]);

                $obj = Rental::create($request->all());


                return ResponseHelper::Out("Rental created successfully", $obj, 201);
            }
        } catch (\Throwable $th) {

            return ResponseHelper::Out("Rental created fail", $th->getMessage(), 409);
        }
    }




    public function update(Request $request, $id)
    {

        try {

            $obj = Rental::find($id);

            $obj->update($request->all());

            if ($obj) {
                return ResponseHelper::Out("Rent update successfully", null, 200);
            }
            return ResponseHelper::Out("Rent update fail", null, 400);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Rent update fail", null, 400);
        }
    }


    public function delete(Request $request, $id)
    {

        try {
            $obj = Rental::find($id);

            $obj->delete();

            return ResponseHelper::Out("Rent delete successfully", null, 204);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Rent delete fail", $th->getMessage(), 400);
        }
    }
}
