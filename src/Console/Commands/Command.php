<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

use Illuminate\Console\GeneratorCommand as BaseGeneratorCommand;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

// use Symfony\Component\Finder\Finder;

abstract class Command extends BaseGeneratorCommand
{
    use Concerns\BuildingClasses;
    use Concerns\InteractiveCommands;
    use Concerns\PackageConfiguration;

    /**
     * @var array<string, mixed>
     */
    public const CONFIGURATION = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => 'App',
        'organization' => '',
        'package' => 'app',
    ];

    /**
     * @var array<string, string>
     */
    public const SEARCH = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => 'App',
        'organization' => '',
        'package' => 'app',
    ];

    /**
     * @var string Uses base_path() to get the directory.
     */
    public const STUBS = 'vendor/gammamatrix/playground-stub/stubs';

    /**
     * The qualified name from the input name.
     */
    protected string $qualifiedName = '';

    /**
     * Parse the input for a class name.
     */
    public function parseClassInput(mixed $input): string
    {
        return empty($input) || ! is_string($input) ? '' : str_replace('/', '\\', ltrim($input, '\\/'));
    }

    /**
     * Parse the input for a class name stored in a JSON configuration file.
     */
    public function parseClassConfig(mixed $input): string
    {
        return empty($input) || ! is_string($input) ? '' : str_replace(['\\', '\\\\'], '/', ltrim($input, '\\/'));
    }

    /**
     * @return array<string, mixed>
     */
    protected function get_configuration(): array
    {
        return static::CONFIGURATION;
    }

    /**
     * @return array<string, string>
     */
    protected function get_search(): array
    {
        return static::SEARCH;
    }

    protected function getType(): string
    {
        return $this->type;
    }

    /**
     * Build the class with the given name.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        if (empty($this->searches['namespacedUserModel'])) {
            $userProviderModel = $this->userProviderModel();
            if (is_string($userProviderModel)) {
                $this->searches['namespacedUserModel'] = $userProviderModel;
                $this->searches['NamespacedDummyUserModel'] = $userProviderModel;
            }
        }

        if (empty($this->searches['namespacedUserModel'])) {
            $this->searches['rootNamespace'] = $this->rootNamespace();
            $this->searches['DummyRootNamespace'] = $this->rootNamespace();
        }

        $stub = $this->files->get($this->getStub());
        $this->search_and_replace($stub);

        return $stub;
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     */
    protected function resolveStubPath($stub): string
    {
        return $this->laravel->basePath(sprintf('%1$s/%2$s', static::STUBS, $stub));
    }

    /**
     * Create the stub directory in storage for the generated code.
     */
    protected function disk(): FilesystemAdapter
    {
        $disk = config('playground-stub.disk');
        $disk = empty($disk) || ! is_string($disk) ? 'local' : $disk;

        return Storage::disk($disk);
    }

    // /**
    //  * Create the stub directory in storage for the generated code.
    //  */
    // protected function createStubDirectory(): void
    // {
    //     if (!$this->disk()->exists('stub')) {
    //         $this->disk()->makeDirectory('stub');
    //     }
    // }

    // /**
    //  * Create the stub directory in storage for the generated code.
    //  */
    // protected function createTypeDirectory(): void
    // {
    //     if (!$this->disk()->exists('stub')) {
    //         $this->disk()->makeDirectory('stub');
    //     }
    // }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        // throw new \Exception('DOH!');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$rootNamespace' => $rootNamespace,
        // ]);
        return $this->parseClassInput($rootNamespace);
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        $rootNamespace = '';
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->hasOption(namespace)' => $this->hasOption('namespace'),
        // ]);
        if ($this->hasOption('namespace') && $this->option('namespace')) {
            $rootNamespace = $this->parseClassInput($this->option('namespace'));
        } elseif (! empty($this->configuration['namespace']
            && is_string($this->configuration['namespace']))
        ) {
            $rootNamespace = $this->parseClassInput($this->configuration['namespace']);
        }

        if (empty($rootNamespace)) {
            $rootNamespace = $this->laravel->getNamespace();
        } else {
            if (! str_ends_with($rootNamespace, '\\')) {
                $rootNamespace .= '\\';
            }
        }

        return $rootNamespace;
    }

    protected function getPath($name): string
    {
        if (empty($this->configuration['package'])) {
            $this->configuration['package'] = 'app';
        }

        $path = sprintf(
            '%1$s/%2$s.php',
            $this->folder(),
            is_string($this->configuration['class']) ? $this->configuration['class'] : 'SomeClass'
        );
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder' => $this->folder,
        //     '$this->configuration[package]' => $this->configuration['package'],
        //     '$name' => $name,
        //     '$path' => $path,
        //     'rootNamespace()' => $this->rootNamespace(),
        // ]);

        return $this->laravel->storagePath().$path;
    }

    // protected function getDestinationPath(): string
    // {
    //     $path = static::PATH_DESTINATION;

    //     if (! empty($this->configuration['package'])) {
    //         $path .= '/'.ltrim($this->configuration['package'], '/');
    //     }

    //     if (static::PATH_DESTINATION_FOLDER) {
    //         $path .= '/'.ltrim(static::PATH_DESTINATION_FOLDER, '/');
    //     }

    //     return $path;
    // }

    protected function search_and_replace(string &$stub): self
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder' => $this->folder,
        //     '$this->searches' => $this->searches,
        //     '$this->configuration' => $this->configuration,
        //     // '$this->configuration[package]' => $this->configuration['package'],
        //     'rootNamespace()' => $this->rootNamespace(),
        // ]);
        foreach ($this->searches as $search => $value) {
            $stub = str_replace([
                sprintf('{{%1$s}}', $search),
                sprintf('{{ %1$s }}', $search),
            ], $value, $stub);
        }

        return $this;
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the '.strtolower($this->type)],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        return [
            ['force',           'f',  InputOption::VALUE_NONE,     'Create the class even if the '.strtolower($this->type).' already exists'],
            ['interactive',     'i',  InputOption::VALUE_NONE,     'Use interactive mode to create the class even for the '.strtolower($this->type)],
            ['model',           'm',  InputOption::VALUE_OPTIONAL, 'The model that the '.strtolower($this->type).' applies to'],
            ['module',          null, InputOption::VALUE_OPTIONAL, 'The module that the '.strtolower($this->type).' belongs to'],
            ['namespace',       null, InputOption::VALUE_OPTIONAL, 'The namespace of the '.strtolower($this->type)],
            ['type',            null, InputOption::VALUE_OPTIONAL, 'The configuration type of the '.strtolower($this->type)],
            ['organization',    null, InputOption::VALUE_OPTIONAL, 'The organization of the '.strtolower($this->type)],
            ['package',         null, InputOption::VALUE_OPTIONAL, 'The package of the '.strtolower($this->type)],
            ['preload',         null,  InputOption::VALUE_NONE,    'Preload the existing configuration file for the '.strtolower($this->type)],
            ['class',           null, InputOption::VALUE_OPTIONAL, 'The class name of the '.strtolower($this->type)],
            ['extends',         null, InputOption::VALUE_OPTIONAL, 'The class that gets extended for the '.strtolower($this->type)],
            ['file',            null, InputOption::VALUE_OPTIONAL, 'The configuration file of the '.strtolower($this->type)],
            ['model-file',      null, InputOption::VALUE_OPTIONAL, 'The configuration file of the model for the '.strtolower($this->type)],
        ];
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<int, mixed>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [];
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->option(file)' => $this->option('file'),
        //     '$this->hasOption(file)' => $this->hasOption('file'),
        // ]);

        // if ($this->hasOption('file') && $this->option('file')) {
        //     return [];
        // }

        // return parent::promptForMissingArgumentsUsing();
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     */
    protected function qualifyClass($name): string
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        $rootNamespace = $this->rootNamespace();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$rootNamespace' => $rootNamespace,
        //     '$name' => $name,
        // ]);

        if (empty($this->configuration['class'])) {
            $this->configuration['class'] = class_basename($name);
            $this->searches['class'] = $this->configuration['class'];
        }

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;
        // return $this->qualifyClass(
        //     $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        // );
        // return trim($rootNamespace, '\\').'\\'.$name;
    }
}
