<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Car;
use App\Models\Admin\Rental;
use App\Models\User;
use Illuminate\Http\Request;



class PageController extends Controller
{



    // Admin page
    public function carList(Request $request)
    {
        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadTokenAsAdmin($token);

        if ($isLogin == "unauthorized") {
            return redirect('/login');
        }

        return view('pages.admin.car-list-page');
    }

    public function rentListPage(Request $request)
    {

        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadTokenAsAdmin($token);

        if ($isLogin == "unauthorized") {
            return redirect('/login');
        }





        $car_obj = Car::get();
        $user_obj = User::where('role', 'customer')->get();

        return view('pages.admin.car-rent-list-page', ["users" => $user_obj, "cars" => $car_obj]);
    }

    public function customerListPage(Request $request)
    {
        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadTokenAsAdmin($token);

        if ($isLogin == "unauthorized") {
            return redirect('/login');
        }
        return view('pages.admin.customer-list-page');
    }




    public function LoginPage(Request $request)
    {
        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadToken($token);

        if ($isLogin != "unauthorized") {
            return redirect('/');
        }

        return view('pages.user.login-page');
    }

    public function SingupPage(Request $request)
    {
        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadToken($token);

        if ($isLogin != "unauthorized") {
            return redirect('/');
        }

        return view('pages.user.singup-page');
    }

    public function DashboardPage(Request $request)
    {
        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadTokenAsAdmin($token);

        if ($isLogin == "unauthorized") {
            return redirect('/login');
        }

        $available_car = 0;
        $unavailable_car = 0;
        $num_of_car = 0;



        $xx = Car::withCount('active_rent')->get();


        $total_earning = Rental::where("status", "Completed")->sum('total_cost');

        foreach ($xx as $elem) {
            if ($elem->active_rent_count == 0) {
                $available_car++;
            } else {
                $unavailable_car++;
            }
            $num_of_car++;
        }




        return view('pages.admin.dashboard-page', [
            "available_car" => $available_car,
            "unavailable_car" => $unavailable_car,
            "num_of_car" => $num_of_car,
            "total_earning" => $total_earning
        ]);
    }

    // user page
    public function Home(Request $request)
    {


        return view('pages.user.home-page');
    }

    public function MakeBookingPage(Request $request, $id)
    {
        return view('pages.user.booking-car-page', ['id' => $id]);
    }


    public function ContactPage(Request $request)
    {
        return view('pages.user.contact-page');
    }

    public function ManageBookingPage(Request $request)
    {
        $token = $request->cookie('token');

        $isLogin = JWTToken::ReadToken($token);

        if ($isLogin == "unauthorized") {
            return redirect('/');
        }
        return view('pages.user.manage-booking-page');
    }

    public function AboutPage(Request $request)
    {
        return view('pages.user.about-page');
    }
}
