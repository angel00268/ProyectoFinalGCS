<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\User;
use App\Models\User as ModelsUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function the_users_table_route_is_working()
    {
        $this->actingAs(ModelsUser::factory()->create());

        $this->get('/usuarios')
            ->assertStatus(200);
    }

    /** @test */
    public function the_user_component_can_render()
    {
        $this->actingAs(ModelsUser::factory()->create());

        $component = Livewire::test(User::class);

        $component->assertStatus(200);
    }
}
