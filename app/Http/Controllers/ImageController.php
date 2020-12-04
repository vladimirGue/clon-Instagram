<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class ImageController extends Controller
{
    public function create(){
        return view('images.create');
    }
    public function save(Request $request){

        //validando datos
        $validate = $this->validate($request, [
            'image_path' => 'required|image',
            'description' => 'required'
        ]);

        //recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //asignar valores al objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;
        
            //subir fichero
            if ($image_path) {
                $image_path_name = time().$image_path->getClientOriginalName();
                Storage::disk('images')->put($image_path_name, File::get($image_path));
                $image->image_path = $image_path_name;
            }
        
            $image->save();

            return redirect()->route('dashboard')->with([
                'message' => 'La foto ha sido subida correctamente'
            ]);
    }
    //obtener imagenes subidas
    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }
    public function detail($id){
        $image = Image::find($id);

        return view('images.detail', [
            'image' => $image
        ]);
    }
    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if ($user && $image && $image->user->id == $user->id) {
            return view('images.edit',['image' => $image]);
        }else{
            return redirect()->route('/dashboard');
        }
    }
    public function update(Request $request){
        //validando datos
        $validate = $this->validate($request, [
            'image_path' => 'image',
            'description' => 'required'
        ]);

        //recoger los datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //Buscar el objeto en la base de datos
        $image = Image::find($image_id);
        $image->description = $description;

        //subir fichero
        if ($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        //Actualizar registro
        $image->update();

        return redirect()->route('image.detail', ['id' => $image_id])
                                ->with(['message' => 'Imagen actualizada con exito']);

    }
}
