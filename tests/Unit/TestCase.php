<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Stub;

use Playground\Stub\ServiceProvider;
use Playground\ServiceProvider as PlaygroundServiceProvider;
use Playground\Test\OrchestraTestCase;

/**
 * \Tests\Unit\Playground\Stub\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use FileTrait;

    protected function getPackageProviders($app)
    {
        return [
            PlaygroundServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('stub.providers.users.model', 'Playground\\Models\\User');
        $app['config']->set('playground-stub.verify', 'user');
        $app['config']->set('stub.testing.password', 'password');
        $app['config']->set('stub.testing.hashed', false);
    }
}
