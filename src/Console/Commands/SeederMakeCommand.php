<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * \Playground\Stub\Console\Commands\SeederMakeCommand
 */
#[AsCommand(name: 'playground:make:seeder')]
class SeederMakeCommand extends GeneratorCommand
{
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
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('laravel/seeder.stub');
    }

    // /**
    //  * Resolve the fully-qualified path to the stub.
    //  *
    //  * @param  string  $stub
    //  * @return string
    //  */
    // protected function resolveStubPath($stub)
    // {
    //     return is_file($customPath = $this->laravel->basePath(trim($stub, '/')))
    //         ? $customPath
    //         : __DIR__.$stub;
    // }

    // /**
    //  * Get the destination class path.
    //  *
    //  * @param  string  $name
    //  * @return string
    //  */
    // protected function getPath($name)
    // {
    //     $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

    //     if (is_dir($this->laravel->databasePath().'/seeds')) {
    //         return $this->laravel->databasePath().'/seeds/'.$name.'.php';
    //     }

    //     return $this->laravel->databasePath().'/seeders/'.$name.'.php';
    // }

    // /**
    //  * Get the root namespace for the class.
    //  *
    //  * @return string
    //  */
    // protected function rootNamespace()
    // {
    //     return 'Database\Seeders\\';
    // }
}
