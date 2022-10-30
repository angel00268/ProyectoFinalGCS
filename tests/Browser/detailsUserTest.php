<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class detailsUserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testDetailtUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->type('email','super_admin@gcs.com')
            ->type('password', 'Super123')
            ->press('login')
            ->waitForLocation('/dashboard')
            ->clickLink('Usuarios')
            ->waitForLocation('/usuarios')
            ->visit('/usuarios/ronaldo07/detalles')
            ->assertSee('Perfil del usuario Cristiano Ronaldo')
            ->pause(4000);
        });
    }
}
