<?php

use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\Factories\UserFactory;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\CreateRule;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\EditRule;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\ListRules;
use Squarebit\FilamentVolition\Tests\Support\TestObject;
use Squarebit\Volition\Database\Factories\RuleFactory;
use Squarebit\Volition\Models\Rule;

use function Pest\Livewire\livewire;

beforeEach(function () {
    Auth::loginUsingId(UserFactory::new()->create()->id);
    FilamentVolition::registerVolitionals(TestObject::class);
});

test('can create rule', function () {
    livewire(CreateRule::class)
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('applies_to');
});

test('can list rules', function () {
    $count = random_int(1, 5);
    RuleFactory::new()->forObject(TestObject::class)->count($count)->create();

    livewire(ListRules::class)
        ->assertCountTableRecords($count)
        ->assertCanSeeTableRecords(Rule::all());
});

test('can edit rule', function () {
    RuleFactory::new()->forObject(TestObject::class)->create();

    livewire(EditRule::class, ['record' => Rule::first()->id])
        ->assertFormFieldIsVisible('name');
});
