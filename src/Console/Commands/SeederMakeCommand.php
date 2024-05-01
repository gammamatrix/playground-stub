<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Stub\Configuration\Seeder as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * \Playground\Stub\Console\Commands\SeederMakeCommand
 */
#[AsCommand(name: 'playground:make:seeder')]
class SeederMakeCommand extends GeneratorCommand
{
    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    protected string $path_destination_folder = 'database/seeders';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('laravel/seeder.stub');
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->before('Seeder')->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    // /**
    //  * Get the root namespace for the class.
    //  *
    //  * @return string
    //  */
    // protected function rootNamespace()
    // {
    //     return 'Database\Seeders\\';
    // }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = 'Database\\Seeders';

        if ($rootNamespace && is_string($rootNamespace) && ! in_array(
            $rootNamespace, [
                'app',
                'App',
            ]
        )) {
            $namespace = Str::of($namespace)
                ->finish('\\')
                ->append($this->parseClassInput($rootNamespace))
                ->toString();
        }

        return $namespace;

    }
}
