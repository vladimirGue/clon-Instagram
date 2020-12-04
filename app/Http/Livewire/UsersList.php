<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UsersList extends Component
{
    public $foo;
    public $search = '';
    public $page = 1;
    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->fill(request()->only('search', 'page'));
    }

    public function render()
    {
        if (empty($this->search)) {
            $users = User::OrderBy('id', 'desc')->paginate(5);
        }else{
            $users = User::where('nick', 'LIKE', '%'.$this->search.'%')
                                ->orWhere('name','LIKE','%'.$this->search.'%')
                                ->OrderBy('id', 'desc')
                                ->paginate(5);
        }
        return view('livewire.users-list', [
            'users' => $users,
        ]);
    }
}
