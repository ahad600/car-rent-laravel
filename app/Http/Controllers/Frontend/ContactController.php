<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    public function sendMail(Request $request)
    {

        try {

            $admin_obj = User::where('role', "admin")->first();

            Mail::to($admin_obj->email)->send(new ContactMail($request));

            return ResponseHelper::Out('', '', 200);
        } catch (\Throwable $th) {
            return ResponseHelper::Out('', '', 401);
        }
    }
}
