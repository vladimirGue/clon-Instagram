<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

class CommentController extends Controller
{
    public function save(Request $request){

        //validacion
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        //recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //guardar en la base de datos
        $comment->save();

        //hacer una redireccion
        return redirect()->route('image.detail',['id' => $image_id])->with(['message' => 'Se ha registrado el comentario']);
    }
    public function delete($id){

        //conseguir datos del usuario identificado
        $user = \Auth::user();

        //conseguir objeto del comentario
        $comment = Comment::find($id);

        //comprobar si soy el dueño del comentario o de la publicacion
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            $comment->delete();

            return redirect()->route('image.detail',['id' => $comment->image->id])
                                ->with(['message' => 'Comentario eliminado correctamente']);
        }else{
            return redirect()->route('image.detail',['id' => $comment->image->id])
                                ->with(['message' => 'Comentario no eliminado']);
        }

    }
}
