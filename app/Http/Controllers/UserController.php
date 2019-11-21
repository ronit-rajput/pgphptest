<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use http\Env\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    public function getUser($id){
        try{
            $user = \App\User::find($id);
            return \View::make('view',compact('user'));
        }catch (\Exception $e){
            return redirect()->back();
        }
    }
}
