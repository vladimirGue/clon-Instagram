<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class HomeController extends Controller
{
    public function dashboard(){

        $images = Image::orderBy('id','desc')->paginate(2);//poner siempre el get o algun metodo para poder obtener datos
        return view('dashboard',[
            'images' => $images
        ]);
    }
}
