<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
//    public function admin(){
//    	echo "123abc";
//    }
    public function  admin(Request $request)
    {
        $echostr = $request -> input('echostr');
        echo $echostr;die;
    }
}
