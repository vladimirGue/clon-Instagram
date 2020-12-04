<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';//indicamos la tabla que va a modificar este modelo

    //relacion One To Many / de uno a muchos
    public function comments(){
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');//obtengo el array objeto de los comentarios
    }

    //relacion One To Many / de uno a muchos
    public function likes(){
        return $this->hasMany('App\Models\Like');//obtiene todos los like de acuerdo al id de la imagen

    }

    //Relacion de muchos a uno
    public function user(){
        // se encarga de buscar los objetos cuyo id sean igual al user_id
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
