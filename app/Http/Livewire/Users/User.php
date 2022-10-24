<?php

namespace App\Http\Livewire\Users;

use App\Models\User as ModelsUser;
use Illuminate\Support\Collection;
use Livewire\Component;

class User extends Component
{
    public Collection $users;
    public bool $confirm = false;
    public int $user_id;

    public function confirm($id = null) {
        $this->confirm = $this->confirm ? false : true;
        $this->user_id = $id?:0;
    }

    public function delete() {
        try {
            ModelsUser::find($this->user_id)->delete();
            $this->confirm();
            session()->flash('success', 'El usuario ha sido eliminado exitosamente.');
            $this->emit('scrollTop');
        } catch (\Illuminate\Validation\ValidationException | \Throwable $th) {
            session()->flash('error', 'Error: Parece que hubo un error, intentelo más tarde, por favor.');
            $this->emit('scrollTop');
        }
    }

    public function render()
    {
        $this->users = auth()->user()->is_admin ? ModelsUser::where('is_admin',0)->get() : ModelsUser::select('users.*')->join('user_details','user_id','users.id')->where('is_admin',0)->where('role','Investigador')->where('country_id',auth()->user()->user_detail->country_id)->get();
        return view('livewire.users.user');
    }
}
