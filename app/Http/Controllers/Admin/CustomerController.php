<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use App\Helper\ResponseHelper;
use Nette\Utils\Arrays;

class CustomerController extends Controller
{


    public function customerList(Request $request)
    {

        $query = User::query();

        $query->where('role', 'customer');

        return ResponseHelper::Out("", $query->get(), 200);
    }

    public function customerGetById(Request $request, $id)
    {

        $query = User::where('role', 'customer')->where('id', $id)->first();

        return ResponseHelper::Out("", $query, 200);
    }







    public function create(Request $request)
    {


        try {

            $obj = new User();

            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->password = $request->password;


            if ($request->has('number') && $request->number == null) {
                $obj->number = '';
            } else {
                $obj->number = $request->number;
            }

            if ($request->has('address') && $request->address == null) {
                $obj->address = '';
            } else {
                $obj->address = $request->address;
            }
            $obj->role = 'customer';

            $obj->save();

            return ResponseHelper::Out("Customer created successfully", null, 201);
        } catch (\Throwable $th) {

            return ResponseHelper::Out("Customer created fail", $th->getMessage(), 409);
        }
    }


    public function update(Request $request, $id)
    {

        try {

            $updated_arr = array();

            $obj = User::find($id);

            if ($request->has('number') && $request->number == null) {
                $updated_arr['number'] = '';
            } else {
                $updated_arr['number'] = $request->number;
            }

            if ($request->has('address') && $request->address == null) {
                $updated_arr['address'] = '';
            } else {
                $updated_arr['address'] = $request->address;
            }

            $updated_arr['name'] = $request->name;

            $obj->update($updated_arr);

            if ($obj) {
                return ResponseHelper::Out("User update successfully", null, 200);
            }

            return ResponseHelper::Out("User update fail", null, 400);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("User update fail", $th->getMessage(), 400);
        }
    }


    public function delete(Request $request, $id)
    {

        try {
            User::where('id', $id)->where('role', 'customer')->delete();
            return ResponseHelper::Out("Rent delete successfully", null, 204);
        } catch (\Throwable $th) {
            return ResponseHelper::Out("Rent delete fail", $th->getMessage(), 400);
        }
    }
}
