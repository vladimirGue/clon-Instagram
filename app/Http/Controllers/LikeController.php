<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function like($image_id){

        //recoger datos de usuario y la imagen
        $user = \Auth::user();

        //condicion para ver si el like ya existe y no duplicar
        $isset_like = Like::where('user_id', $user->id)
                                ->where('image_id', $image_id)
                                ->count();
        if ($isset_like == 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            //guardar
            $like->save();
            return response()->json([
                'like' => $like
            ]);
        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
        
    }
    public function dislike($image_id){

        //recoger datos de usuario y la imagen
        $user = \Auth::user();

        //condicion para ver si el like ya existe y no duplicar
        $like = Like::where('user_id', $user->id)
                                ->where('image_id', $image_id)
                                ->first();
        if ($like) {

            //Eliminar

            //guardar
            $like->delete();
            return response()->json([
                'like' => $like,
                'message' => 'dislike'
            ]);
        }else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
    }
    public function favoritos(){
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')
                            ->paginate(2);

        return view('favoritos.index', [
            'likes' => $likes
        ]);
    }
}
