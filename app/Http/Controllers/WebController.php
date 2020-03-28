<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function mainScreen(){
        return \Illuminate\Support\Facades\Redirect::to('https://covidarnost.ru/');
    }
}
