<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\CreateOrUpdateUser;
use App\Http\Livewire\Users\User as LivewireUser;
use App\Models\Country;
use App\Models\User;
use App\Models\UserDetail;
use App\Providers\RouteServiceProvider;
use Livewire\Livewire;
use Tests\TestCase;

class UserCreateIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();
    }

    /** @test */
    public function can_create_user_from_login_action_to_redirect_to_users_view()
    {
        $response = $this->post("/login", [
            'email' => "super_admin@gcs.com",
            'password' => 'Super123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->get(RouteServiceProvider::HOME)
            ->assertViewIs('dashboard')
            ->assertSee('Bienvenido Super Administrador');

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSeeLivewire('users.user')
            ->assertSee('Usuarios');

        $userComponent = Livewire::test(LivewireUser::class)
            ->assertStatus(200)
            ->assertSeeHtml('<a href="http://localhost/usuarios/crear" class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight  rounded-full shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out">Agregar usuario</a>');
        $this->assertTrue($userComponent->users != null);

        $this->get('/usuarios/crear')
            ->assertStatus(200)
            ->assertSeeLivewire('users.create-or-update-user')
            ->assertSee('Registro de usuarios');

        $createComponent = Livewire::test(CreateOrUpdateUser::class)
            ->assertStatus(200);
        $this->assertEquals(new User(), $createComponent->user_state);
        $this->assertEquals(new UserDetail(), $createComponent->state);
        $this->assertEquals(count($createComponent->countries), count(Country::all()));

        $createComponent->set('user_state.name', 'juan')
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juan@gmail.com')
            ->set('password', 'juan1234')
            ->set('password_confirm', 'juan1234')
            ->set('state.first_name', 'Juan')
            ->set('state.second_name', null)
            ->set('state.first_surname', 'Perez')
            ->set('state.second_surname', null)
            ->set('state.second_email', null)
            ->set('state.cell_phone', '78964520')
            ->set('state.landline', null)
            ->set('state.address', null)
            ->set('state.workplace', null)
            ->set('state.position', null)
            ->set('state.description', null)
            ->set('state.country_id', 1)
            ->set('state.role', 'Administrador')
            ->call('create')
            ->assertHasNoErrors([
                'user_state.name',
                'user_state.email',
                'password',
                'password_confirm',
                'email_confirm',
                'state.first_name',
                'state.second_name',
                'state.first_surname',
                'state.second_surname',
                'state.second_email',
                'state.cell_phone',
                'state.landline',
                'state.address',
                'state.workplace',
                'state.position',
                'state.description',
                'state.country_id',
                'state.role'
            ])
            ->assertSuccessful();

        $this->assertModelExists(User::where('email','juan@gmail.com')->get()[0]);
        $this->assertModelExists(UserDetail::where('first_name','Juan')->get()[0]);

        $createComponent->assertRedirect('/usuarios')->assertSessionHas('success');
        $newUserComponent = Livewire::test(LivewireUser::class)
            ->assertSee('El usuario ha sido agregado exitosamente.');
        $this->assertEquals(User::where('email','juan@gmail.com')->get()[0]->id, $newUserComponent->users[1]->id);
    }
}
