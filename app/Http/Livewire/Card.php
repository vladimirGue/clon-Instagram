<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Card extends Component
{

    public $image;
    /**
     * Constructor para cargar datos
     *
     * @return void
     */
    public function mount($image)
    {
        $this->image = $image;
    }

    public function render()
    {
        return view('livewire.card');
    }
}
