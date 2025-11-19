<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\Factories\UserFactory;

beforeEach(function () {
    Auth::loginUsingId(UserFactory::new()->create()->id);
});

test('can has menu', function () {
    $this->get(Filament::getHomeUrl().'/volition')
        ->assertSuccessful()
        ->assertSee('Rules');
});
