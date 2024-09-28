<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;



class JWTToken
{
    public static function CreateToken($userEmail, $userID, $role, $name): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 24 * 60 * 60,
            'userEmail' => $userEmail,
            'userID' => $userID,
            'role' => $role,
            'name' => $name,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }


    public static function ReadToken($token): string|object
    {
        try {
            if ($token == null) {
                return 'unauthorized';
            } else {
                $key = env('JWT_KEY');
                return JWT::decode($token, new Key($key, 'HS256'));
            }
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }

    public static function ReadTokenAsAdmin($token): string|object
    {
        try {
            if ($token == null) {
                return 'unauthorized';
            } else {
                $key = env('JWT_KEY');

                $userInfo = JWT::decode($token, new Key($key, 'HS256'));

                if ($userInfo->role != "admin") {
                    return 'unauthorized';
                }

                return $userInfo;
            }
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }
}
