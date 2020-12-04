<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Image;
use Illuminate\Support\Collection;

class ModalDetail extends Component
{
    public $user;

    /**
     * funcion  para cargar datos al inciar
     * el componente
     *
     * @return void
     */
    public function mount($user)
    {
        $this->user = $user;
    }

    /**
     * funciona para mostrar el componente modal detalles
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal-detail');
    }
}
