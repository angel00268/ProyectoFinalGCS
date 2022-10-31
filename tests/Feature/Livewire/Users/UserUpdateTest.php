<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\CreateOrUpdateUser;
use App\Models\Country;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();
    }

    /** @test */
    public function the_user_update_route_is_working()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/usuarios/angel/actualizar")
            ->assertStatus(200);
    }

    /** @test */
    public function the_user_update_component_can_render()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/usuarios/angel/actualizar")
            ->assertSeeLivewire(CreateOrUpdateUser::class);
    }

    /** @test */
    public function the_user_update_title_is_showing()
    {
        $user = User::find(2);
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->assertSee("Actualización de usuario {$user->user_detail->fullName()}");
    }

    /** @test */
    public function the_user_update_state_instance_is_set()
    {
        $user = User::find(2);
        $component = Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->assertViewHas('user_state', $user);
        $this->assertEquals($user, $component->user);
    }

    /** @test */
    public function the_user_detail_update_state_instance_is_set()
    {
        $user = User::find(2);
        $component = Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->assertSet('state', $user->user_detail);
        $this->assertEquals($user->user_detail, $component->user_detail);
    }

    /** @test */
    public function the_countries_collection_is_set()
    {
        $countries = Country::select('name', 'id')->get()->pluck('name', 'id');
        $user = User::find(2);
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->assertSet('countries', $countries);
    }

    /** @test */
    public function the_action_option_is_set_to_update()
    {
        $user = User::find(2);
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->assertSet('action', 'update');
    }

    /** @test */
    public function validate_required_and_nullable_inputs_as_super_admin()
    {
        $this->post("/login", [
            'email' => "super_admin@gcs.com",
            'password' => 'Super123',
        ]);

        $user = User::find(2);

        Livewire::test(CreateOrUpdateUser::class, ['user' => $user])
            ->set('user_state.name', 'juan')
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juan@gmail.com')
            ->set('state.first_name', 'Juan')
            ->set('state.first_surname', 'Perez')
            ->set('state.cell_phone', '78964520')
            ->set('state.country_id', 1)
            ->set('state.role', 'Administrador')
            ->call('update')
            ->assertHasNoErrors([
                'user_state.name',
                'user_state.email',
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
    public function validate_required_and_nullable_inputs_as_admin()
    {
        $this->post("/login", [
            'email' => "angel@gcs.com",
            'password' => 'Angel123',
        ]);

        Livewire::test(CreateOrUpdateUser::class)
            ->set('user_state.name', 'juan')
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juan@gmail.com')
            ->set('state.first_name', 'Juan')
            ->set('state.first_surname', 'Perez')
            ->set('state.cell_phone', '78964520')
            ->call('update')
            ->assertHasNoErrors([
                'user_state.name',
                'user_state.email',
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
    public function scroll_top_is_emitted_after_updating_user()
    {
        $user = User::find(2);
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->set('user_state.name', 'juan')
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juan@gmail.com')
            ->set('state.first_name', 'Juan')
            ->set('state.first_surname', 'Perez')
            ->set('state.cell_phone', '78964520')
            ->set('state.country_id', 1)
            ->set('state.role', 'Administrador')
            ->call('update')
            ->assertHasNoErrors([
                'user_state.name',
                'user_state.email',
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
            ->assertEmitted('scrollTop');
    }

    /** @test */
    public function alert_appear_after_updating_user()
    {
        $user = User::find(2);
        Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->set('user_state.name', 'juan')
            ->set('user_state.email', 'juan@gmail.com')
            ->set('email_confirm', 'juan@gmail.com')
            ->set('state.first_name', 'Juan')
            ->set('state.first_surname', 'Perez')
            ->set('state.cell_phone', '78964520')
            ->set('state.country_id', 1)
            ->set('state.role', 'Administrador')
            ->call('update')
            ->assertHasNoErrors([
                'user_state.name',
                'user_state.email',
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
            ->assertSee('La información del usuario ha sido actualizada exitosamente.');
    }

    /** @test */
    public function the_user_has_been_updated()
    {
        $user = User::find(2);
        $component = Livewire::actingAs(User::factory()->create())
            ->test(CreateOrUpdateUser::class, ['user' => $user])
            ->set('user_state.name', 'juan')
            ->set('state.second_name', 'Juan')
            ->set('state.second_surname', 'Perez')
            ->set('state.cell_phone', '78964520')
            ->call('update')
            ->assertSuccessful();
        $this->assertEquals($component->user->name, 'juan');
        $this->assertEquals($component->user_detail->cell_phone, '78964520');
    }
}
