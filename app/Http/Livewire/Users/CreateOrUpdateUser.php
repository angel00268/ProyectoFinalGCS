<?php

namespace App\Http\Livewire\Users;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Country;
use App\Models\User;
use Livewire\Component;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CreateOrUpdateUser extends Component
{
    use PasswordValidationRules;

    public $user;
    public $user_detail;
    public $countries;
    public $state = [];
    public $user_state = [];
    public string $action = 'create';
    public string $title = "Registro de usuarios";
    public string $password = "";
    public string $password_confirm = "";
    public string $email_confirm = "";

    protected function rules(): array
    {
        return [
            'state.first_name' => ['required', 'string', 'max:25'],
            'state.second_name' => ['nullable', 'string', 'max:25'],
            'state.first_surname' => ['required', 'string', 'max:25'],
            'state.second_surname' => ['nullable', 'string', 'max:25'],
            'user_state.email' => [
                Rule::unique('users', 'email')->ignore($this->user),
                Rule::unique('user_details', 'second_email')->ignore($this->user_detail),
                'required',
                'email',
                'max:255',
                'same:email_confirm'
            ],
            'email_confirm' => ['required', 'string', 'email', 'max:255', 'same:user_state.email'],
            'user_state.name' => ['required', 'max:25', Rule::unique('users', 'name')->ignore($this->user)],
            'state.second_email' => [
                'nullable', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user),
                Rule::unique('user_details', 'second_email')->ignore($this->user_detail),
            ],
            'password' => $this->action == "create" ? $this->passwordRules() : ['nullable'],
            'password_confirm' => $this->action == "create" ? ['required','same:password'] : ['nullable'],
            'state.cell_phone' => ['required', 'max:9', Rule::unique('user_details', 'cell_phone')->ignore($this->user_detail)],
            'state.landline' => ['nullable', 'max:9', Rule::unique('user_details', 'landline')->ignore($this->user_detail)],
            'state.role' => auth()->user()->is_admin ? ['required', Rule::in(['Administrador', 'Investigador'])] : ['nullable'],
            'state.country_id' => auth()->user()->is_admin ? ['required'] : ['nullable'],
            'state.address' => ['nullable', 'max:255'],
            'state.description' => ['nullable', 'max:255'],
            'state.workplace' => ['nullable', 'max:255'],
            'state.position' => ['nullable', 'max:255'],
        ];
    }

    protected $validationAttributes =  [
        'state.first_name' => 'Primer nombre',
        'state.second_name' => 'Segundo nombre',
        'state.first_surname' => 'Primer apellido',
        'state.second_surname' => 'Segundo apellido',
        'user_state.email' => 'Correo electrónico',
        'email_confirm' => 'Confirmación de correo electrónico',
        'user_state.name' => 'Nombre de usuario',
        'state.second_email' => 'Segundo correo electrónico',
        'password' => 'Contraseña',
        'password_confirm' => 'Confirmación de contraseña',
        'state.cell_phone' => 'Teléfono celular',
        'state.landline' => 'Teléfono fijo',
        'state.role' => 'Rol',
        'state.country_id' => 'País',
        'state.address' => 'Dirección',
        'state.description' => 'Titular/biografía',
        'state.workplace' => 'Lugar de trabajo',
        'state.position' => 'Cargo',
    ];

    public function mount(User $user)
    {
        $this->countries = Country::select('name', 'id')->get()->pluck('name', 'id');
        if (isset($user->id)) {
            $this->user_state = $user;
            $this->user_detail = $user->user_detail;
            $this->state = $this->user_detail;
            $this->action = "update";
            $this->title = "Actualización de usuario {$user->user_detail->fullName()}";
            $this->email_confirm = $user->email;
        } else {
            $this->user_state = new User();
            $this->state = new UserDetail();
        }
    }

    public function create_user($data): User {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($this->password),
        ]);
    }

    public function create_user_detail($user, $data): UserDetail {
        $data['user_id'] = $user->id;
        if (!auth()->user()->is_admin) {
            $data['role'] = "Investigador";
            $data['country_id'] = auth()->user()->user_detail->country_id;
        }
        return  UserDetail::create($data);
    }

    public function create()
    {
        try {
            $data = $this->validate();
            $user = $this->create_user($data['user_state']);
            $this->create_user_detail($user,$data['state']);
            $user->sendEmailVerificationNotification();
            $this->resetErrorBag();
            session()->flash('success', 'El usuario ha sido agregado exitosamente.');
            return redirect()->route('user.index');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            $this->emit('scrollTop');
            session()->flash('error', 'Error: Verifique que todos los campos hayan sido completados correctamente, por favor.');
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException | \Throwable $th) {
            session()->flash('error', 'Error: Parece que hubo un error, intentelo más tarde, por favor.');
            $this->emit('scrollTop');
        }
    }

    public function update()
    {
        try {
            $data = $this->validate();
            $this->user->update([
                'name' => $data['user_state']['name'],
                'email' => $data['user_state']['email'],
            ]);
            $this->user_detail->update($data['state']);
            $this->resetErrorBag();
            session()->flash('success', 'La información del usuario ha sido actualizada exitosamente.');
            $this->emit('scrollTop');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            $this->emit('scrollTop');
            session()->flash('error', 'Error: Verifique que todos los campos hayan sido completados correctamente, por favor.');
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException | \Throwable $th) {
            session()->flash('error', 'Error: Parece que hubo un error, intentelo más tarde, por favor.');
            $this->emit('scrollTop');
        }
    }

    public function render()
    {
        return view('livewire.users.create-or-update-user');
    }
}
