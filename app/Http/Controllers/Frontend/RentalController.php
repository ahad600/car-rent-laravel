<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Mail\Email;
use App\Models\Admin\Car;
use Carbon\Carbon;
use App\Models\Admin\Rental;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;




class RentalController extends Controller
{
    public function create(Request $request)
    {

        try {
            DB::beginTransaction();

            $user_id = $request->header('id');

            $user_email = $request->header('email');

            $car_id = $request->car_id;

            $start_date = $request->start_date;

            $end_date = $request->end_date;

            $startDate = Carbon::parse($start_date);

            $endDate = Carbon::parse($end_date);

            $car_rental_count_ongoing = Rental::where("car_id", $car_id)

                ->where(function ($query) {
                    $query->where("status", "Ongoing")
                        ->orWhere("status", "Booked");
                })

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

                $user_obj = User::where('role', "admin")->first();

                if (!$car_obj) {

                    return ResponseHelper::Out("Rental car is not available", null, 404);
                }

                $daysDifference = $startDate->diffInDays($endDate);

                $total_cost = $car_obj->daily_rent_price * $daysDifference;

                $request->merge(['user_id' => $user_id, 'car_id' => $car_id, "total_cost" => $total_cost]);

                $obj = Rental::create($request->all());

                Mail::to([$user_email, $user_obj->email])->send(new Email(["rent" => $obj, "car" => $car_obj]));

                DB::commit();

                return ResponseHelper::Out("Rental created successfully", $obj, 201);
            }
        } catch (\Throwable $th) {

            DB::rollBack();

            return ResponseHelper::Out("Rental created fail", $th->getMessage(), 409);
        }
    }

    public function rentalList(Request $request)
    {

        $user_id = $request->header('id');

        $query = Rental::select(
            'rentals.id',
            'cars.name',
            'cars.brand',
            'total_cost',
            'status',
            'start_date',
            'end_date'
        )
            ->join('cars', 'cars.id', '=', 'car_id')
            ->where('user_id', $user_id)
            ->orderBy('id', 'DESC');

        // return ResponseHelper::Out("", $user_id, 200);

        return ResponseHelper::Out("", $query->get(), 200);
    }


    public function rentalCancel(Request $request, $id)
    {

        try {

            $obj = Rental::where('id', $id)->where('user_id', $request->header('id'))
                ->where('status', 'Booked');

            $obj->update(['status' => "Canceled"]);

            if ($obj) {
                return ResponseHelper::Out("Rent Canceled successfully", null, 200);
            }
            return ResponseHelper::Out("Rent Canceled fail", null, 400);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Rent Canceled fail", null, 400);
        }
    }
}
