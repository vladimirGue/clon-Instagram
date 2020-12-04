<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }
    /**
     * funcion para la vista perfil del usuario
     *
     * @param  mixed $id
     * @return void
     */
    public function profile($id){
        $users = User::all();
        $user = $users->find($id);
        return view('user.profile', [
            'user' => $user
        ]);
    }
}
