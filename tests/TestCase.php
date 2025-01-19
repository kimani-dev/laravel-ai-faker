<?php

namespace Kimani\LaravelAiFaker\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kimani\LaravelAiFaker\Providers\AIFakerServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AIFakerServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Register the factories
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Kimani\\LaravelAiFaker\\Tests\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }
}
