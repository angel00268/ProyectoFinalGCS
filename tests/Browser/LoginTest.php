<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email','super_admin@gcs.com')
                    ->type('password', 'Super123')
                    ->press('login')
                    ->waitForLocation('/dashboard')
                    ->assertSee('Bienvenido Super Administrador');
        });
    }
    
}
