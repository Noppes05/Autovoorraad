<?php

use Laravel\Dusk\Browser;

test('welcome page shows the public navigation links', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee('Log in')
            ->assertSee('Register');
    });
});

test('login page shows the login form', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->assertSee('Welkom terug')
            ->assertSee('Inloggen')
            ->assertSee('Wachtwoord vergeten?');
    });
});

test('register page shows the registration form', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/register')
            ->assertSee('Registreren')
            ->assertSee('Rol')
            ->assertSee('Al een account?');
    });
});
