<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserDetail extends Component
{
    public User $user;
    public int $option = 1;

    public function mount()
    {
        if (request()->op) {
            $this->option = request()->op;
        }
    }

    public function render()
    {
        return view('livewire.users.user-detail');
    }
}
