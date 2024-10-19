<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function frontpage(){
        return view('home.homepage');
    }
   public function view(){
    return "hello";
   }
}
