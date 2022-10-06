<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function ttt(Request $request){
        return response()->json([
            'a'=>'aaa',
            'b'=>'bbb',
            'c'=>'ccc',
        ]);
    }

    public function login(Request $request){
        // return response()->json($request->all());
        // return response()->json($request->input('name'));

        $name=$request->input('name');
        $user=User::where('name',$name)->orWhere('email',$name)->first();

        if(!$user){
            return response()->json(['result'=>'error','msg'=>'用戶名稱或密碼錯誤']);
        }

        $password=$request->input('password');
        $db_password=$user->password;


        if(Hash::check($password, $db_password)){
            return response()->json(['result'=>'success','msg'=>'用戶名稱密碼正確']);
        }

        return response()->json(['error'=>'用戶名稱或密碼錯誤']);

    }


}
