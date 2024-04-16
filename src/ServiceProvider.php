<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

/**
 * \Playground\Stub\ServiceProvider
 */
class ServiceProvider extends AuthServiceProvider
{
    public const VERSION = '73.0.0';

    protected string $package = 'playground-stub';

    /**
     * Bootstrap any package services.
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /**
         * @var array<string, mixed> $config
         */
        $config = config($this->package);

        if (! empty($config['load']) && is_array($config['load'])) {

            if (! empty($config['load']['commands'])) {
                $this->boot_commands();
            }

            if (! empty($config['load']['translations'])) {
                $this->loadTranslationsFrom(
                    dirname(__DIR__).'/lang',
                    $this->package
                );
            }

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package) => config_path(sprintf('%1$s.php', $this->package)),
                ], 'playground-config');
            }
        }

        if (! empty($config['about'])) {
            $this->about();
        }
    }

    /**
     * @return array<int, class-string<GeneratorCommand>>
     */
    public function boot_commands(): array
    {
        $commands = [];

        $commands[] = Console\Commands\ControllerMakeCommand::class;
        // $commands[] = Console\Commands\DocsMakeCommand::class;
        $commands[] = Console\Commands\FactoryMakeCommand::class;
        $commands[] = Console\Commands\MigrationMakeCommand::class;
        $commands[] = Console\Commands\ModelMakeCommand::class;
        $commands[] = Console\Commands\PackageMakeCommand::class;
        $commands[] = Console\Commands\PolicyMakeCommand::class;
        $commands[] = Console\Commands\RequestMakeCommand::class;
        // $commands[] = Console\Commands\ResourceMakeCommand::class;
        // $commands[] = Console\Commands\RouteMakeCommand::class;
        $commands[] = Console\Commands\TemplateMakeCommand::class;
        $commands[] = Console\Commands\TestMakeCommand::class;
        $commands[] = Console\Commands\SeederMakeCommand::class;

        $this->commands($commands);

        return $commands;
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package),
            $this->package
        );
    }

    public function about(): void
    {
        $config = config($this->package);
        $config = is_array($config) ? $config : [];

        $load = ! empty($config['load']) && is_array($config['load']) ? $config['load'] : [];

        $version = $this->version();

        AboutCommand::add('Playground: Stub', fn () => [
            '<fg=yellow;options=bold>Load</> Commands' => ! empty($load['commands']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Translations' => ! empty($load['translations']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    public function version(): string
    {
        return static::VERSION;
    }
}
