<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Test as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

// use Playground\Stub\Configuration\Configuration;

/**
 * \Playground\Stub\Console\Commands\TestMakeCommand
 */
#[AsCommand(name: 'playground:make:test')]
class TestMakeCommand extends GeneratorCommand
{
    use Concerns\Tests;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    // /**
    //  * @var array<string, mixed>
    //  */
    // public const CONFIGURATION = [
    //     'organization' => '',
    //     'package' => 'app',
    //     'fqdn' => '',
    //     'namespace' => '',
    //     'model' => '',
    //     'model_column' => '',
    //     'model_label' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'name' => '',
    //     'folder' => '',
    //     'class' => '',
    //     'type' => '',
    //     'table' => '',
    //     'extends' => '\Tests\TestCase',
    //     'implements' => [],
    //     'properties' => [],
    //     'setup' => [],
    //     'tests' => [],
    //     'HasOne' => [],
    //     'HasMany' => [],
    //     'uses' => [],
    // ];

    /**
     * @var array<string, string>
     */
    public const SEARCH = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => '',
        'extends' => '',
        'implements' => '',
        'organization' => '',
        'use' => '',
        'use_class' => '',
        'properties' => '',
        'table' => '',
        'setup' => '',
        'tests' => '',
        'model_fqdn' => '',
        'hasRelationships' => 'false',
        'hasMany_properties' => '',
        'hasOne_properties' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new test case';

    protected string $suite = 'unit';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';

    protected string $path_destination_folder = 'tests';

    public function prepareOptions(): void
    {
        $options = $this->options();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     // '$this->configuration' => $this->configuration,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);

        $type = $this->getConfigurationType();

        $suite = $this->option('suite');
        $suite = is_string($suite) ? strtolower($suite) : '';
        $this->suite = empty($suite) || ! in_array($suite, [
            'acceptance',
            'feature',
            'unit',
        ]) ? 'unit' : $suite;

        $this->c->setOptions([
            'folder' => Str::of($this->suite)->title()->toString(),
        ]);

        if (in_array($type, [
            'model',
            'playground-api',
            'playground-resource',
            'playground-model',
        ])) {

            if ($this->model?->fqdn()) {
                $this->c->setOptions([
                    'model_fqdn' => $this->model->fqdn(),
                ]);
                $this->searches['model_fqdn'] = $this->parseClassInput($this->c->model_fqdn());
            }

            if (in_array($this->suite, [
                'acceptance',
                'feature',
            ])) {
                $this->buildClass_uses_add('GammaMatrix\Playground\Test\Feature\Models\ModelCase');
                $this->c->setOptions([
                    'extends' => 'ModelCase',
                ]);
            } else {
                $this->buildClass_uses_add('GammaMatrix\Playground\Test\Unit\Models\ModelCase');
                $this->c->setOptions([
                    'extends' => 'ModelCase',
                ]);
            }

            $this->buildClass_hasOne($type, $this->suite);
            $this->buildClass_hasMany($type, $this->suite);

            // } elseif ($type === 'controller') {
            // } elseif ($type === 'playground-resource-index') {
            // } elseif ($type === 'playground-resource') {
        } else {
        }

        $this->applyConfigurationToSearch();
        if (is_string($this->c->name())) {
            $this->buildClass_uses($this->c->name());
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches' => $this->searches,
        //     '$this->options()' => $this->options(),
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        return ! is_string($this->c->name()) ? '' : sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    // /**
    //  * Build the class with the given name.
    //  *
    //  * @param  string  $name
    //  * @return string
    //  */
    // protected function buildClass($name)
    // {
    //     // $this->buildClass_model($name);
    //     return parent::buildClass($name);
    // }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     */
    protected function qualifyClass($name): string
    {
        $type = $this->getConfigurationType();
        // return parent::qualifyClass($name);
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        // ]);

        if (in_array($type, [
            'model',
            'playground-api',
            'playground-resource',
            'playground-model',
        ])) {
            $this->c->setOptions([
                'class' => 'ModelTest',
            ]);
            // } elseif ($type === 'controller') {
            // } elseif ($type === 'playground-resource-index') {
            // } elseif ($type === 'playground-resource') {
        } else {
            $this->c->setOptions([
                'class' => 'InstanceTest',
            ]);
        }

        $this->searches['class'] = $this->c->class();

        $rootNamespace = $this->rootNamespace();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$rootNamespace' => $rootNamespace,
        // ]);

        return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$this->c->class();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     '$this->options()' => $this->options(),
        // ]);
        // return $this->c->class();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        $type = $this->getConfigurationType();

        // if ($type === 'playground-resource') {
        //     $this->handle_playground_resource();
        // }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     // '$this->model' => $this->model,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     '$this->options()' => $this->options(),
        // ]);

        // $this->saveConfiguration();
    }

    // protected function handle_playground_resource()
    // {

    //     // $tests = [];

    //     // $tests['detail.blade.php'] = 'test/playground/resource/model/detail.blade.php.stub';
    //     // $tests['form.blade.php'] = 'test/playground/resource/model/form.blade.php.stub';
    //     // $tests['form-info.blade.php'] = 'test/playground/resource/model/form-info.blade.php.stub';
    //     // $tests['form-publishing.blade.php'] = 'test/playground/resource/model/form-publishing.blade.php.stub';
    //     // $tests['form-status.blade.php'] = 'test/playground/resource/model/form-status.blade.php.stub';
    //     // // $tests['index'] = 'test/playground/resource/model/index.blade.php.stub';

    //     // // Str::of($this->c->name())->kebab()

    //     // foreach ($tests as $test => $source) {

    //     //     // $path_stub = 'test'.$test;
    //     //     $path = $this->resolveStubPath($source);

    //     //     $destination = sprintf(
    //     //         '%1$s/%2$s%3$s',
    //     //         $this->folder(),
    //     //         $this->configuration['folder'] ? $this->configuration['folder'].'/' : '',
    //     //         $test
    //     //     );
    //     //     // dd([
    //     //     //     '__METHOD__' => __METHOD__,
    //     //     //     '$source' => $source,
    //     //     //     '$path' => $path,
    //     //     //     '$destination' => $destination,
    //     //     //     '$this->configuration' => $this->configuration,
    //     //     //     '$this->folder' => $this->folder(),
    //     //     // ]);
    //     //     $stub = $this->files->get($path);

    //     //     $this->search_and_replace($stub);

    //     //     $full_path = $this->laravel->storagePath().$destination;
    //     //     $this->files->put($full_path, $stub);

    //     //     $this->components->info(sprintf('Test: %s [%s] created successfully.', $test, $full_path));
    //     // }
    // }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $test = 'test/test.stub';

        $type = $this->getConfigurationType();

        if (in_array($type, [
            'playground-model',
            'playground-resource',
            'playground-api',
        ])) {
            $test = 'test/model/playground.stub';
        } elseif ($type === 'playground') {
            $test = 'test/test.stub';
        } elseif ($type === 'playground-resource-index') {
            $test = 'test/test.stub';
        } elseif ($type === 'playground-resource') {
            $test = 'test/test.stub';
        }

        return $this->resolveStubPath($test);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = Str::of(
            Str::of($this->suite)->studly()->toString()
        )->prepend('Tests\\')->toString();

        if ($rootNamespace && is_string($rootNamespace)) {
            $namespace = Str::of($namespace)
                ->finish('\\')
                ->append($this->parseClassInput($rootNamespace))
                ->toString();
        }

        $name = $this->c->name();
        if ($name) {
            $namespace = Str::of($namespace)
                ->finish('\\')
                ->append(Str::of($name)->studly()->toString())
                ->toString();
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$rootNamespace' => $rootNamespace,
        //     '$namespace' => $namespace,
        //     '$name' => $name,
        //     '$this->c' => $this->c,
        // ]);

        return $namespace;

    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['suite', null, InputOption::VALUE_OPTIONAL, 'The test suite: unit|feature|acceptance'];

        return $options;
    }

    protected function folder(): string
    {
        if (empty($this->folder) && is_string($this->c->name())) {
            $this->folder = sprintf(
                '%1$s/%2$s/%3$s',
                $this->getDestinationPath(),
                Str::of($this->suite)->studly()->toString(),
                Str::of($this->c->name())->studly()->toString()
            );
        }

        return $this->folder;
    }
}
