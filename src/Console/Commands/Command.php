<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

use Illuminate\Console\GeneratorCommand as BaseGeneratorCommand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

// use Playground\Stub\Configuration\Configuration;

// use Symfony\Component\Finder\Finder;

abstract class Command extends BaseGeneratorCommand
{
    use Concerns\Files;
    use Concerns\InteractiveCommands;
    use Concerns\PackageConfiguration;

    /**
     * @var class-string<ConfigurationContract>
     */
    public const CONF = ConfigurationContract::class;

    protected ConfigurationContract $c;

    // /**
    //  * @var array<string, mixed>
    //  */
    // public const CONFIGURATION = [
    //     'class' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'namespace' => 'App',
    //     'organization' => '',
    //     'package' => 'app',
    // ];

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

    // /**
    //  * @var string Uses base_path() to get the directory.
    //  */
    // public const STUBS = 'vendor/gammamatrix/playground-stub/stubs';

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

    protected function get_configuration(bool $reset = false): ConfigurationContract
    {
        if ($reset || empty($this->c)) {
            $c = static::CONF;
            $this->c = new $c;
        }

        return $this->c;
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
            $this->searches['rootNamespace'] = $this->rootNamespace();
            $this->searches['DummyRootNamespace'] = $this->rootNamespace();
            $userProviderModel = $this->userProviderModel();
            if (is_string($userProviderModel) && $userProviderModel) {
                $this->searches['namespacedUserModel'] = $userProviderModel;
                $this->searches['NamespacedDummyUserModel'] = $userProviderModel;
            }
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
        $path = '';
        $stub_path = config('playground-stub.paths.stubs');
        if (! empty($stub_path)
            && is_string($stub_path)
        ) {
            if (! is_dir($stub_path)) {
                Log::error(__('playground-stub::stub.Command.path.invalid'), [
                    '$stub_path' => $stub_path,
                    '$stub' => $stub,
                ]);
            } else {
                $path = sprintf(
                    '%1$s/%2$s',
                    // Str::of($stub_path)->finish('/')->toString(),
                    Str::of($stub_path)->toString(),
                    $stub
                );
            }
        }

        if (empty($path)) {
            $path = sprintf(
                '%1$s/resources/stubs/%2$s',
                dirname(dirname(dirname(__DIR__))),
                $stub
            );
        }

        if (! file_exists($path)) {
            $this->components->error(__('playground-stub::stub.Command.stub.missing', [
                'stub_path' => is_string($stub_path) ? $stub_path : gettype($stub_path),
                'stub' => $stub,
                'path' => $path,
            ]));
        }

        return $path;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->parseClassInput($rootNamespace);
    }

    // /**
    //  * Get the full namespace for a given class, without the class name.
    //  *
    //  * @param  string  $name
    //  * @return string
    //  */
    // protected function getNamespace($name)
    // {
    //     return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    // }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        $rootNamespace = $this->laravel->getNamespace();
        if ($this->hasOption('namespace') && $this->option('namespace')) {
            $rootNamespace = $this->parseClassInput($this->option('namespace'));
        } elseif ($this->c->namespace()) {
            $rootNamespace = $this->parseClassInput($this->c->namespace());
        }

        if (! str_ends_with($rootNamespace, '\\')) {
            $rootNamespace .= '\\';
        }

        return $rootNamespace;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     */
    protected function getPath($name): string
    {
        $path = sprintf(
            '%1$s/%2$s.php',
            $this->folder(),
            $this->c->class()
        );

        return $this->laravel->storagePath().$path;
    }

    protected function search_and_replace(string &$stub): self
    {
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

    // /**
    //  * Adds an option.
    //  *
    //  * @param $shortcut The shortcuts, can be null, a string of shortcuts delimited by | or an array of shortcuts
    //  * @param $mode     The option mode: One of the InputOption::VALUE_* constants
    //  * @param $default  The default value (must be null for InputOption::VALUE_NONE)
    //  * @param array|\Closure(CompletionInput,CompletionSuggestions):list<string|Suggestion> $suggestedValues The values used for input completion
    //  *
    //  * @return $this
    //  *
    //  * @throws InvalidArgumentException If option mode is invalid or incompatible
    //  */
    // public function addOption(string $name, string|array|null $shortcut = null, ?int $mode = null, string $description = '', mixed $default = null, array|\Closure $suggestedValues = []): static
    // {
    //     $this->definition->addOption(new InputOption($name, $shortcut, $mode, $description, $default, $suggestedValues));
    //     $this->fullDefinition?->addOption(new InputOption($name, $shortcut, $mode, $description, $default, $suggestedValues));

    //     return $this;
    // }

    protected ?string $options_type_default = null;

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [];

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
            ['type',            null, InputOption::VALUE_OPTIONAL, 'The configuration type of the '.strtolower($this->type), $this->options_type_default, $this->options_type_suggested],
            ['organization',    null, InputOption::VALUE_OPTIONAL, 'The organization of the '.strtolower($this->type)],
            ['package',         null, InputOption::VALUE_OPTIONAL, 'The package of the '.strtolower($this->type)],
            ['preload',         null,  InputOption::VALUE_NONE,    'Preload the existing configuration file for the '.strtolower($this->type)],
            ['skeleton',        null, InputOption::VALUE_NONE,     'Create the skeleton for the '.strtolower($this->type).' type'],
            ['class',           null, InputOption::VALUE_OPTIONAL, 'The class name of the '.strtolower($this->type)],
            ['extends',         null, InputOption::VALUE_OPTIONAL, 'The class that gets extended for the '.strtolower($this->type)],
            ['file',            null, InputOption::VALUE_OPTIONAL, 'The configuration file of the '.strtolower($this->type)],
            ['model-file',      null, InputOption::VALUE_OPTIONAL, 'The configuration file of the model for the '.strtolower($this->type)],
        ];
    }

    // /**
    //  * Prompt for missing input arguments using the returned questions.
    //  *
    //  * @return array<int, mixed>
    //  */
    // protected function promptForMissingArgumentsUsing(): array
    // {
    //     return [];
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     '$this->option(file)' => $this->option('file'),
    //     //     '$this->hasOption(file)' => $this->hasOption('file'),
    //     // ]);

    //     // if ($this->hasOption('file') && $this->option('file')) {
    //     //     return [];
    //     // }

    //     // return parent::promptForMissingArgumentsUsing();
    // }

    protected bool $qualifiedNameStudly = true;

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     */
    protected function qualifyClass($name): string
    {
        // $name = ltrim($name, '\\/');

        // $name = str_replace('/', '\\', $name);

        // if ($this->qualifiedNameStudly && ! ctype_upper($name)) {
        //     $name = Str::of($name)->studly()->toString();
        // }

        $rootNamespace = $this->rootNamespace();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$rootNamespace' => $rootNamespace,
        //     '$name' => $name,
        // ]);

        if (empty($this->c->class())) {
            $this->c->setOptions([
                'class' => class_basename($name),
            ]);
            $this->searches['class'] = $this->c->class();
        }

        // if (Str::startsWith($name, $rootNamespace)) {
        //     return $name;
        // }

        return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;
        // return $this->qualifyClass(
        //     $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        // );
        // return trim($rootNamespace, '\\').'\\'.$name;
    }
}
