<?php

namespace Squarebit\FilamentVolition\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Factories\UserFactory;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Squarebit\FilamentVolition\FilamentVolitionServiceProvider;
use Squarebit\FilamentVolition\Tests\Support\TestPanelProvider;
use Squarebit\FilamentVolition\Tests\Support\User;
use Squarebit\Volition\VolitionServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(UserFactory::new()->create(['email' => 'test@user.com']));

        $migration = include __DIR__ . '/../vendor/square-bit/laravel-volition/database/migrations/create_volition_tables.php.stub';
        $migration->up();
    }

    protected function getPackageProviders($app): array
    {
        return [
            VolitionServiceProvider::class,
            FilamentVolitionServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            ActionsServiceProvider::class,
            WidgetsServiceProvider::class,
            SupportServiceProvider::class,
            NotificationsServiceProvider::class,
            TablesServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            TestPanelProvider::class,
        ];
    }


    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('auth.providers.users.model', User::class);
        config()->set('app.key', 'rE9Nz59b4TE1beMTftriyQjrpF7DcOQm');
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
    }
}
