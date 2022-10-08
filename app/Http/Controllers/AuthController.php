<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Psr\Http\Message\ResponseInterface;

use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    public function login()
    {

        $loginField = request('name');
        $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        request()->merge([$loginType => $loginField]);


        $credentials = request([$loginType, 'password']);

        if (!$token = auth()->attempt($credentials)) {

            $err_msg = '用戶名稱或密碼不正確';
            return response()->json(['error' => $err_msg], 401);
        }

        $user = Auth::user();
        // return $this->respondWithToken($token);

        // if($jwt=request()->cookie('jwt')){

        //     return response()->json(['jwt'=>$token,'cookie'=>$jwt]);
        // }

        return response()->json($token)
        ->withCookie(
            'jwt', //$name
            $token, //$value
            3600,  //$minutes
            null,  //$path
            null,  //$domain
            true,  //$secure
            true,  //$httpOnly
            false, //$raw
            'none'  //$sameSite
        );
        ;
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->logout();

        Cookie::forget('jwt');

        return response()->json(['message' => 'Successfully logged out'])->withCookie(
            'jwt', //$name
            'logged out', //$value
            3600,  //$minutes
            null,  //$path
            null,  //$domain
            true,  //$secure
            true,  //$httpOnly
            false, //$raw
            'none'  //$sameSite
        );
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600
        ]);
    }
}
