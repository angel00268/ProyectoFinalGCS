<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\User;
use App\Models\User as ModelsUser;
use Livewire\Livewire;
use Tests\TestCase;
class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();
    }

    /** @test */
    public function the_users_show_route_is_working()
    {
        $this->actingAs(ModelsUser::factory()->create());
        $this->get('/usuarios')
            ->assertStatus(200);
    }

    /** @test */
    public function the_user_component_can_render()
    {
        $this->actingAs(ModelsUser::factory()->create());
        $this->get('/usuarios')->assertSeeLivewire(User::class);
    }

    /** @test */
    public function can_toggle_confirmation_delete_modal()
    {
        $this->actingAs(ModelsUser::factory()->create());
        Livewire::test(User::class)
                ->call('confirm')
                ->assertViewHas('confirm',true);
    }

    /** @test */
    public function the_user_has_been_soft_deleted()
    {
        $this->actingAs($user = ModelsUser::factory()->create());
        Livewire::test(User::class)
                    ->set('user_id',$user->id)
                    ->call('delete');
        $this->assertSoftDeleted($user);
    }

    /** @test */
    public function alert_appear_after_soft_deleted_user()
    {
        $this->actingAs($user = ModelsUser::factory()->create());
        Livewire::test(User::class)
                    ->set('user_id',$user->id)
                    ->call('delete')
                    ->assertSee('El usuario ha sido eliminado exitosamente.');
    }

    /** @test */
    public function scroll_top_is_emitted()
    {
        $this->actingAs($user = ModelsUser::factory()->create());
        Livewire::test(User::class)
                    ->set('user_id',$user->id)
                    ->call('delete')
                    ->assertEmitted('scrollTop');
    }

    /** @test */
    public function the_fetching_users_method_only_returns_instance_of_users()
    {
        $this->actingAs(ModelsUser::factory()->create());
        $component = Livewire::test(User::class);
        $this->assertContainsOnlyInstancesOf(ModelsUser::class,$component->users);
    }
}
