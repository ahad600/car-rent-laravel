<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function UserLogin(Request $request): JsonResponse
    {
        try {
            $UserEmail = $request->email;
            $Password = $request->password;

            $user = User::Where('email', $UserEmail)->where('password', $Password)->first();

            if ($user) {

                $token = JWTToken::CreateToken($UserEmail, $user->id, $user->role, $user->name);

                return ResponseHelper::Out('success', "", 200)->cookie('token', $token, 60 * 24 * 30);
            } else {
                return ResponseHelper::Out('fail', "", 401);
            }
        } catch (Exception $e) {
            return ResponseHelper::Out('fail', $e, 400);
        }
    }


    public function UserSingup(Request $request)
    {
        try {

            // return ResponseHelper::Out('', $request->all(), 200);

            User::create($request->all());

            return ResponseHelper::Out("User create successfully", '', 200);
        } catch (\Throwable $th) {
            return ResponseHelper::Out('User create fail', "", 400);
        }
    }

    public function userCheck(Request $request)
    {
        try {
            $token = $request->cookie('token');
            $result = JWTToken::ReadToken($token);
            if ($result == "unauthorized") {
                return ResponseHelper::Out('unauthorized', null, 401);
            } else {
                return $result;
            }
        } catch (Exception $e) {
            return ResponseHelper::Out('fail', $e, 400);
        }
    }


    function UserLogout()
    {
        return redirect('/login')->cookie('token', '', -1);
    }
}
