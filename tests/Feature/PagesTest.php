<?php

it('shows the home page in Dutch', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="nl">', escape: false)
        ->assertSee('Binnenkort geef je hier een pluim aan jouw vlieglocatie.');
});

it('shows the about page', function () {
    $this->get('/over')
        ->assertOk()
        ->assertSee('Over Vliegplezier');
});

it('answers the health check', function () {
    $this->get('/up')->assertOk();
});
