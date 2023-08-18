<?php

use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\Factories\UserFactory;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\EditRule;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers\ConditionsRelationManager;
use Squarebit\FilamentVolition\Tests\Support\TestObject;
use Squarebit\Volition\Database\Factories\RuleFactory;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Auth::loginUsingId(UserFactory::new()->create()->id);


});

test('can list conditions', function () {
    $rule = RuleFactory::new()->forObject(TestObject::class)->create();

    livewire(ConditionsRelationManager::class, [
        'ownerRecord' => $rule,
        'pageClass' => EditRule::class,
    ])
        ->assertSuccessful()
        ->assertCanSeeTableRecords([]);
});

test('can list action', function () {
    $rule = RuleFactory::new()->forObject(TestObject::class)->create();

    livewire(ConditionsRelationManager::class, [
        'ownerRecord' => $rule,
        'pageClass' => EditRule::class,
    ])
        ->assertSuccessful()
        ->assertCanSeeTableRecords([]);
});
