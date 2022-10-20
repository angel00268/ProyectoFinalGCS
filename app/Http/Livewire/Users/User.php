<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

class User extends Component
{
    public $title = "Usuarios";

    public function render()
    {
        return view('livewire.users.user');
    }
}
