<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends DuskTestCase
{
    /**
     * Visiting page link and response.
     *
     * @test
     * @group home
     *
     * @return void
     */
    public function it_should_be_work_for_each_link()
    {
        $this->browse(function ($laravel, $login, $register) {
            $laravel->visit('/')
                ->assertSee('Laravel');

            $login->visit('/')
                ->clickLink('Login')
                ->assertRouteIs('login');

            $register->visit('/')
                ->clickLink('Register')
                ->assertRouteIs('register');
        });
    }
}
