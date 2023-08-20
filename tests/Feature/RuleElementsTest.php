<?php

use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\Factories\UserFactory;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Actions\CreateElementAction;
use Squarebit\FilamentVolition\Filament\Actions\EditElementAction;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\EditRule;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers\ActionsRelationManager;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers\ConditionsRelationManager;
use Squarebit\FilamentVolition\Tests\Support\ObjectPropertyCondition;
use Squarebit\FilamentVolition\Tests\Support\PrefixAction;
use Squarebit\FilamentVolition\Tests\Support\SuffixAction;
use Squarebit\FilamentVolition\Tests\Support\TestObject;
use Squarebit\Volition\Database\Factories\RuleFactory;
use Squarebit\Volition\Models\Action;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Auth::loginUsingId(UserFactory::new()->create()->id);

    FilamentVolition::registerConditions(ObjectPropertyCondition::class);
    FilamentVolition::registerActions(PrefixAction::class);
    FilamentVolition::registerActions(SuffixAction::class);
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

test('can list and create actions', function () {
    $rule = RuleFactory::new()->forObject(TestObject::class)->create();
    $condition = new ObjectPropertyCondition('property', 'value');
    $prefixAction = new PrefixAction('prefix');
    $suffixAction = new SuffixAction('prefix');

    $rule->addCondition($condition)
        ->addAction($prefixAction);

    livewire(ConditionsRelationManager::class, [
        'ownerRecord' => $rule,
        'pageClass' => EditRule::class,
    ])
        ->assertCountTableRecords(1)
        ->mountTableAction(CreateElementAction::class)
        ->setTableActionData([
            'payload' => [
                [
                    'type' => $condition::class,
                    'data' => [
                        'property' => 'prop',
                        'value' => 'val',
                    ],
                ],
            ],
        ])
        ->callMountedTableAction()
        ->assertHasNoActionErrors();

    expect($rule->conditions->last()->payload)
        ->property->toBe('prop')
        ->value->toBe('val');

    livewire(ActionsRelationManager::class, [
        'ownerRecord' => $rule,
        'pageClass' => EditRule::class,
    ])
        ->assertCountTableRecords(1)
        ->mountTableAction(CreateElementAction::class)
        ->setTableActionData([
            'payload' => [
                [
                    'type' => $suffixAction::class,
                    'data' => ['suffix' => 'some_suffix'],
                ],
            ],
        ])
        ->callMountedTableAction()
        ->assertHasNoActionErrors();

    expect($rule->actions->last()->payload->suffix)->toBe('some_suffix');
});

test('can edit actions', function () {
    $rule = RuleFactory::new()->forObject(TestObject::class)->create();
    $condition = new ObjectPropertyCondition('property', 'value');
    $prefixAction = new PrefixAction('prefix');
    $suffixAction = new SuffixAction('prefix');

    $rule->addCondition($condition)
        ->addAction($prefixAction);

    $livewire = livewire(ActionsRelationManager::class, [
        'ownerRecord' => $rule,
        'pageClass' => EditRule::class,
    ])
        ->assertCountTableRecords(1)
        ->mountTableAction(EditElementAction::class, Action::first())
        ->callMountedTableAction()
        ->assertHasNoActionErrors();

    expect($rule->actions->last()->payload->prefix)->toBe('prefix');
});
