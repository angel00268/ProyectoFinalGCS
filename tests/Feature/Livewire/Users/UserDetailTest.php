<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\UserDetail;
use App\Models\User;
use Tests\TestCase;

class UserDetailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();
    }

    /** @test */
    public function the_user_detail_show_route_is_working()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/usuarios/angel/detalles")
            ->assertStatus(200);
    }

    /** @test */
    public function the_user_detail_component_can_render()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/usuarios/angel/detalles")
            ->assertSeeLivewire(UserDetail::class);
    }

     /** @test */
    public function the_user_profile_route_is_working()
    {
        $this->post("/login", [
            'email' => "angel@gcs.com",
            'password' => 'Angel123',
        ]);
        $this->get("/perfil/angel")
            ->assertStatus(200);
    }

    /** @test */
    public function the_user_profile_route_is_forbbiden_for_super_admin()
    {
        $this->post("/login", [
            'email' => "super_admin@gcs.com",
            'password' => 'Super123',
        ]);
        $this->get("/perfil/angel")
            ->assertForbidden()
            ->assertStatus(403);
    }
}
