<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\CreateOrUpdateUser;
use App\Http\Livewire\Users\User as UsersUser;
use App\Models\Country;
use App\Models\User;
use App\Models\UserDetail;
use Livewire\Livewire;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();
    }

    /** @test */
    public function the_user_create_route_is_working()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/usuarios/crear")
            ->assertStatus(200);
    }

    /** @test */
    public function the_user_create_component_can_render()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/usuarios/crear")
            ->assertSeeLivewire(CreateOrUpdateUser::class);
    }

    /** @test */
    public function the_user_create_title_is_showing()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->assertSee('Registro de usuarios');
    }

    /** @test */
    public function the_user_state_instance_is_set()
    {
        $component = Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->assertViewHas('user_state', new User());
        $this->assertEquals(new User(), $component->user_state);
    }

    /** @test */
    public function the_user_detail_state_instance_is_set()
    {
        $component = Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->assertSet('state', new UserDetail());
        $this->assertEquals(new UserDetail(), $component->state);
    }

    /** @test */
    public function the_countries_collection_is_set()
    {
        $countries = Country::select('name', 'id')->get()->pluck('name', 'id');
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->assertSet('countries', $countries);
    }

    /** @test */
    public function can_create_user()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->call('create_user', [
                'name'     => 'juan',
                'email'    => 'juan@gmail.com',
                'password' => 'juan1234'
            ])
            ->assertSuccessful();
        $this->assertModelExists(User::findOrFail(4));
    }

    /** @test */
    public function can_create_user_details_as_super_admin()
    {
        $country_id = Country::find(1);
        $user = User::create([
            'name'     => 'juan',
            'email'    => 'juan@gmail.com',
            'password' => 'juan1234'
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->call('create_user_detail', $user, [
                'first_name' => 'Juan',
                'second_name' => 'Alonso',
                'first_surname' => 'Perez',
                'second_surname' => 'Hernandez',
                'second_email' => 'alonso@gmail.com',
                'cell_phone' => '78964520',
                'landline' => '22829586',
                'address' => 'Avenida Melvin Jones, frente al Parque San Martín',
                'workplace' => 'ITCA-Fepade',
                'position' => 'Docente de computación',
                'description' => 'Ing. en Sistemas Informaticos',
                'country_id' => $country_id->id,
                'role' => 'Administrador',
            ])
            ->assertSuccessful();
        $this->assertModelExists(UserDetail::findOrFail(2));
    }

    /** @test */
    public function can_create_user_details_as_admin()
    {
        $this->post("/login", [
            'email' => "angel@gcs.com",
            'password' => 'Angel123',
        ]);

        $user = User::create([
            'name'     => 'juan',
            'email'    => 'juan@gmail.com',
            'password' => 'juan1234'
        ]);

        Livewire::test(CreateOrUpdateUser::class)
            ->call('create_user_detail', $user, [
                'first_name' => 'Juan',
                'second_name' => 'Alonso',
                'first_surname' => 'Perez',
                'second_surname' => 'Hernandez',
                'second_email' => 'alonso@gmail.com',
                'cell_phone' => '78964520',
                'landline' => '22829586',
                'address' => 'Avenida Melvin Jones, frente al Parque San Martín',
                'workplace' => 'ITCA-Fepade',
                'position' => 'Docente de computación',
                'description' => 'Ing. en Sistemas Informaticos',
            ])
            ->assertSuccessful();
        $this->assertModelExists(UserDetail::findOrFail(2));
    }

    /** @test */
    public function validate_user_inputs()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.name', 'juan')
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juan@gmail.com')
            ->set('password', 'juan1234')
            ->set('password_confirm', 'juan1234')
            ->call('create')
            ->assertHasNoErrors(['user_state.name', 'user_state.email', 'password', 'password_confirm', 'email_confirm']);
    }

    /** @test */
    public function validate_user_detail_inputs()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('state.first_name', 'Juan')
            ->set('state.second_name', 'Alonso')
            ->set('state.first_surname', 'Perez')
            ->set('state.second_surname', 'Hernandez')
            ->set('state.second_email', 'alonso@gmail.com')
            ->set('state.cell_phone', '78964520')
            ->set('state.landline', '22829586')
            ->set('state.address', 'Avenida Melvin Jones, frente al Parque San Martín')
            ->set('state.workplace', 'ITCA-Fepade')
            ->set('state.position', 'Docente de computación')
            ->set('state.description', 'Ing. en Sistemas Informaticos')
            ->set('state.country_id', 1)
            ->set('state.role', 'Administrador')
            ->call('create')
            ->assertHasNoErrors([
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
            ]);
    }

    /** @test */
    public function validate_required_and_nullable_inputs()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.name', 'juan')
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
                'password', 'password_confirm',
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
            ]);
    }

    /** @test */
    public function validate_required_inputs()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.name', NULL)
            ->set('user_state.email', NULL)
            ->set('email_confirm', '')
            ->set('password', '')
            ->set('password_confirm', '')
            ->set('state.first_name', NULL)
            ->set('state.first_surname', NULL)
            ->set('state.cell_phone', NULL)
            ->set('state.country_id', NULL)
            ->set('state.role', NULL)
            ->call('create')
            ->assertHasErrors([
                'user_state.name',
                'user_state.email',
                'email_confirm',
                'password',
                'password_confirm',
                'state.first_name',
                'state.first_surname',
                'state.cell_phone',
                'state.country_id',
                'state.role'
            ]);
    }

    /** @test */
    public function validate_email_and_emailconfirmation_should_be_equal()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juaan@gmail.com')
            ->call('create')
            ->assertHasErrors(['user_state.email', 'email_confirm',]);
    }

    /** @test */
    //ACA SE DEBE DE CAMBIAR EL NOMBRE DE LA PROPIEDAD DE PASSWORD CONFIRMATION
    public function validate_password_and_passwordconfirmation_should_be_equal()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('password', 'juan1234')
            ->set('password_confirm', 'juan123')
            ->call('create')
            ->assertHasErrors(['password', 'password_confirm']);
    }

    /** @test */
    public function validate_unique_inputs()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.name', 'angel')
            ->set('user_state.email', 'angel@gcs.com')
            ->set('state.second_email', 'sebastian@gcs.com')
            ->set('state.cell_phone', '1478963')
            ->call('create')
            ->assertHasErrors([
                'user_state.name',
                'user_state.email',
                'state.second_email',
                'state.cell_phone',
            ]);
    }

    /** @test */
    public function can_redirect_to_list_of_users_view_after_creating()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.name', 'juan')
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
                'password', 'password_confirm',
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
            ->assertRedirect('/usuarios');
    }

    /** @test */
    public function show_success_alert_at_users_view_after_creating_user()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class)
            ->set('user_state.name', 'juan')
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
                'password', 'password_confirm',
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
            ->assertRedirect('/usuarios');
        Livewire::test(UsersUser::class)
            ->assertSee('El usuario ha sido agregado exitosamente.');
    }
}
