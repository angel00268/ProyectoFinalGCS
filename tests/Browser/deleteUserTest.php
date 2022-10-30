<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class deleteUserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email','super_admin@gcs.com')
                ->type('password', 'Super123')
                ->press('login')
                ->waitForLocation('/dashboard')
                ->clickLink('Usuarios')
                ->waitForLocation('/usuarios')
                ->click('@delete-ronaldo07')
                ->pause(2000)
                ->click('@delete-si')
                ->pause(3000)
                ->assertSee('El usuario ha sido eliminado exitosamente.');
        });
    }
}
