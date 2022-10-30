<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class addNewUserTest extends DuskTestCase
{
    /**
     * Add new user
     *
     * @return void
     */

    public function testAddNewUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email','super_admin@gcs.com')
                ->type('password', 'Super123')
                ->press('login')
                ->waitForLocation('/dashboard')
                ->clickLink('Usuarios')
                ->waitForLocation('/usuarios')
                ->clickLink('Agregar usuario')
                ->waitForLocation('/usuarios/crear')
                ->assertSee('Registro de usuarios')
                ->type('first_name','Cristiano')
                ->type('first_surname','Ronaldo')
                ->type('second_name','Dos Santos')
                ->type('second_surname','Aveiro')
                ->type('email','cr7@gmail.com')
                ->type('email_confirm','cr7@gmail.com')
                ->type('username','ronaldo07')
                ->type('second_email','cristiano@gmail.com')
                ->type('password','Test1234')
                ->type('password_confirm','Test1234')
                ->type('cell_phone','75256936')
                ->type('landline','22227777')
                ->select('role', 'Administrador')
                ->select('country', '3')
                ->type('address','Lisboa City #25 Edificio A')
                ->type('description','Mejor Futbolist de la Historia')
                ->type('workplace','Manchester United')
                ->type('position','Soccer Player')
                ->press('Crear usuario')
                ->assertSee('El usuario ha sido agregado exitosamente.');
        });
    }
}
