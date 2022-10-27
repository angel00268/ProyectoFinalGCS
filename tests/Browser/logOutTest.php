<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class logOutTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogOut()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email','super_admin@gcs.com')
                    ->type('password', 'Super123')
                    ->press('login')
                    ->waitForLocation('/dashboard')
                    ->press('dropdownInfo')
                    ->clickLink('Log Out')
                    ->assertGuest();
        });
    }
}
