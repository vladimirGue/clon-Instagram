<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Livewire\Component;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;

class CardHorizontal extends Component
{
    public $confirmingPublicationDeletion = false;
    public $id_img;
    public $image;
    public $btn = false;
    protected $listeners = ['newPost'];
    
    public function confirmPublicationDeletion(){
        $this->confirmingPublicationDeletion = true;
    }
    /**
     * funcion que recive un dato como parametro
     * al iniciar el componente
     *
     * @param  mixed $image
     * @return void
     */
    public function mount($image){
        if (!isset($image) || Empty($image)) {
            $this->image = '';
        }else{
            $this->image = $image;
            $this->btn = true;
        }
    }
    
    /**
     * funcion que recive un dato enviado al hacer
     * click desde el componente ModalDetail
     *
     * @param  mixed $id
     * @return void
     */
    public function newPost($id){
        $this->id_img = $id;
    
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id',$id)->get();
        $likes = Like::where('image_id',$id)->get();

        if ($user && $image && $image->user->id == $user->id) {
            //Eliminar comentarios
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            //Eliminar los likes
            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            //Eliminar ficheros de imagen
            Storage::disk('images')->delete($image->image_path);

            //Eliminar registro imagen
            $image->delete();
            session()->flash('message', 'La imagen se ha borrado correctamente.');
        }else{
            session()->flash('message', 'La imagen no se ha borrado correctamente.');
        }
        
        return redirect()->to('/dashboard');
    }
    public function edit($id){

        return redirect()->route('image.edit',[$id]);
       
    }
    public function render()
    {
        return view('livewire.card-horizontal',[
            'images' => Image::all(),
        ]);
    }
}
