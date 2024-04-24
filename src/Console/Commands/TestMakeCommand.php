<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Building;
use Playground\Stub\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Stub\Configuration\Test as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\TestMakeCommand
 */
#[AsCommand(name: 'playground:make:test')]
class TestMakeCommand extends GeneratorCommand
{
    use Building\Concerns\BuildImplements;
    use Building\Concerns\BuildUses;
    use Concerns\Tests;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

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
        $suite = $suite ? $suite : $this->c->suite();

        // NOTE: Suites could be a configuration option.
        $this->suite = empty($suite) || ! in_array($suite, [
            'acceptance',
            'feature',
            'unit',
        ]) ? 'unit' : $suite;

        $this->c->setOptions([
            'suite' => $this->suite,
        ]);

        $this->type = 'Test';
        if ($this->suite) {
            $this->type = Str::of(
                $this->suite
            )->replace('-', ' ')->ucfirst()->finish(' Test')->toString();
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->suite' => $this->suite,
        //     '$this->type' => $this->type,
        // ]);
        $this->c->setOptions([
            'folder' => Str::of($this->suite)->title()->toString(),
        ]);

        if (in_array($type, [
            'model',
            'playground-api',
            'playground-resource',
            'playground-model',
        ])) {

            // The FQDN, from the model, is the source of truth.
            $model_fqdn = $this->model?->fqdn();
            if (! $model_fqdn) {
                $model_fqdn = $this->c->model_fqdn();
            }
            $this->c->setOptions([
                'model_fqdn' => $model_fqdn,
            ]);

            $this->searches['model_fqdn'] = $model_fqdn ? $this->parseClassInput($model_fqdn) : 'ReplaceFqdn';

            $extends = 'ModelCase';

            // if (in_array($this->suite, [
            //     'acceptance',
            //     'feature',
            // ])) {
            //     // $this->buildClass_uses_add('GammaMatrix\Playground\Test\Feature\Models\ModelCase');
            //     $this->c->setOptions([
            //         'extends' => 'ModelCase',
            //     ]);
            // } else {
            //     // $this->buildClass_uses_add('GammaMatrix\Playground\Test\Unit\Models\ModelCase');
            // }
            $this->c->setOptions([
                'extends' => $extends,
            ]);

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
        $type = $this->c->type();

        if (in_array($type, [
            'model',
            'playground-api',
            'playground-resource',
            'playground-model',
        ])) {
            $type = 'test';
        } else {
            $type = 'test';
        }

        return sprintf(
            '%1$s/%2$s.%3$s.json',
            Str::of($this->c->name())->before('Test')->kebab(),
            $type,
            Str::of($this->c->suite())->kebab(),
        );

        // return ! is_string($this->c->name()) ? '' : sprintf(
        //     'test.%1$s.%2$s%3$s%4$s.json',
        //     Str::of($this->c->suite())->kebab(),
        //     Str::of($type)->kebab(),
        //     $type ? '.' : '',
        //     Str::of($this->c->name())->kebab()
        // );
    }

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
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $test = 'test/test.stub';

        $type = $this->getConfigurationType();

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
