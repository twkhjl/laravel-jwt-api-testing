<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function all(){

        // $value = request()->cookie('jwt_token');
        // if(!$value){
        //     return response()->json(['cookie'=>'none']);
        // }else{
        //     return response()->json($value);
        // }

        return response()->json(auth()->user());
        // return response()->json('abc');
    }
}
