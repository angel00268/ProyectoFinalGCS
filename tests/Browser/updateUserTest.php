<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class updateUserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->type('email','super_admin@gcs.com')
            ->type('password', 'Super123')
            ->press('login')
            ->waitForLocation('/dashboard')
            ->clickLink('Usuarios')
            ->waitForLocation('/usuarios')
            ->visit('/usuarios/ronaldo07/actualizar')
            ->waitForLocation('/usuarios/ronaldo07/actualizar')
            ->assertSee('Actualización de usuario Cristiano Ronaldo')
            ->select('country', '178')
            ->press('Actualizar usuario')
            ->pause(5000)
            ->assertSee('La información del usuario ha sido actualizada exitosamente.');
        });
    }
}


