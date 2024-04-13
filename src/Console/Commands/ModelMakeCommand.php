<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
// use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;
use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Model as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function Laravel\Prompts\multiselect;

/**
 * \Playground\Stub\Console\Commands\ModelMakeCommand
 */
#[AsCommand(name: 'playground:make:model')]
class ModelMakeCommand extends GeneratorCommand
{
    // use Concerns\CreatingModels;
    use Concerns\Models;
    use CreatesMatchingTest;
    // use Traits\ModelRelationshipsMakeTrait;
    // use Traits\ModelSkeletonMakeTrait;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    // const CONFIGURATION = [
    //     'organization' => '',
    //     'package' => 'app',
    //     'module' => '',
    //     'module_slug' => '',
    //     'fqdn' => '',
    //     'namespace' => '',
    //     'model' => '',
    //     'name' => '',
    //     'class' => '',
    //     'type' => '',
    //     'table' => '',
    //     'extends' => '',
    //     'implements' => [],
    //     'factory' => false,
    //     'migration' => false,
    //     'policy' => false,
    //     'seed' => false,
    //     'test' => false,
    //     'HasOne' => [],
    //     'HasMany' => [],
    //     'scopes' => [],
    //     'attributes' => [],
    //     'casts' => [],
    //     'fillable' => [],
    //     'filters' => [],
    //     'models' => [],
    //     'sortable' => [],
    //     'create' => [],
    // ];

    const SEARCH = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => 'App\\',
        'extends' => 'Model',
        'implements' => '',
        'organization' => '',
        // 'namespacedModel' => '',
        // 'NamespacedDummyUserModel' => '',
        // 'namespacedUserModel' => '',
        // 'use' => PHP_EOL.'use Illuminate\Database\Eloquent\Factories\HasFactory;'.PHP_EOL.'use Illuminate\Database\Eloquent\Model;'.PHP_EOL,
        // 'use' => PHP_EOL.'use Illuminate\Database\Eloquent\Model;'.PHP_EOL,
        'use' => '',
        // 'use_class' => '    use HasFactory;',
        'use_class' => '',
        'table' => '',
        'property_table' => '',
        // 'perPage' => PHP_EOL.PHP_EOL.'    protected $perPage = 25;',
        'attributes' => '',
        'casts' => '',
        'fillable' => '',
        'perPage' => '',
        'HasMany' => '',
        'HasOne' => '',
        'scopes' => '',
        'filters' => '',
    ];

    protected string $path_destination_folder = 'src/Models';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    // public bool $createAll = false;

    // public bool $createController = false;

    // public bool $createFactory = false;

    // public bool $createMigration = false;

    // public bool $createSeeder = false;

    // public bool $createPolicy = false;

    // public bool $createTest = false;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        // $this->createAll = $this->hasOption('all') && $this->option('all');

        if ($this->hasOption('all') && $this->option('all')) {
            // $this->createController = true;
            // $this->createFactory = true;
            // $this->createMigration = true;
            // $this->createSeeder = true;
            // $this->createPolicy = true;
            // $this->createTest = true;

            $this->c->setOptions([
                'controller' => true,
                'factory' => true,
                'migration' => true,
                'policy' => true,
                'requests' => true,
                'seed' => true,
                'test' => true,
            ]);

        } else {

            // Check options

            if ($this->hasOption('controller') && $this->option('controller')) {
                $this->c->setOptions([
                    'controller' => true,
                ]);
            }

            if ($this->hasOption('factory') && $this->option('factory')) {
                $this->c->setOptions([
                    'factory' => true,
                ]);
            }

            if ($this->hasOption('migration') && $this->option('migration')) {
                $this->c->setOptions([
                    'migration' => true,
                ]);
            }

            if ($this->hasOption('policy') && $this->option('policy')) {
                $this->c->setOptions([
                    'policy' => true,
                ]);
            }

            if ($this->hasOption('requests') && $this->option('requests')) {
                $this->c->setOptions([
                    'requests' => true,
                ]);
            }

            if ($this->hasOption('seed') && $this->option('seed')) {
                $this->c->setOptions([
                    'seed' => true,
                ]);
            }

            if ($this->hasOption('test') && $this->option('test')) {
                $this->c->setOptions([
                    'test' => true,
                ]);
            }

        }

        if ($this->hasOption('pivot') && $this->option('pivot')) {
            $this->c->setOptions([
                'type' => 'pivot',
            ]);
        } elseif ($this->hasOption('morph-pivot') && $this->option('morph-pivot')) {
            $this->c->setOptions([
                'type' => 'morph-pivot',
            ]);
        }

        if (in_array($this->c->type(), [
            'pivot',
            'morph-pivot',
        ])) {
            $this->c->setOptions([
                'migration' => true,
            ]);
        }

        if (in_array($this->c->type(), [
            'api',
        ])) {
            $this->c->setOptions([
                'controller' => true,
                'policy' => true,
            ]);
        }

        if (in_array($this->c->type(), [
            'resource',
            'playground-api',
            'playground-resource',
        ])) {
            $this->c->setOptions([
                'controller' => true,
                'factory' => true,
                'policy' => true,
            ]);
        }

        if ($this->c->factory()) {
            $this->createFactory();
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     // '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     // '$this->createController' => $this->createController,
        //     // '$this->createFactory' => $this->createFactory,
        //     // '$this->createMigration' => $this->createMigration,
        //     // '$this->createSeeder' => $this->createSeeder,
        //     // '$this->createPolicy' => $this->createPolicy,
        //     '$this->options()' => $this->options(),
        // ]);

        if ($this->c->migration()) {
            $this->createMigration();
        }

        if ($this->c->seed()) {
            $this->createSeeder();
        }

        // if ($this->c->controller()) {
        //     $this->createController();
        // }

        if ($this->c->policy()) {
            $this->createPolicy();
        }

        if ($this->c->test()) {
            $this->createTest();
        }

        $this->saveConfiguration();
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        if (in_array($this->c->type(), [
            'abstract',
            'pivot',
            'morph-pivot',
            'playground-abstract',
            'playground-model',
            'model',
            'resource',
            'api',
            'playground-resource',
            'playground-api',
        ])) {
            $this->searches['use'] = '';
            $this->searches['use_class'] = '';

            // if ($this->option('skeleton')) {
            //     $this->buildClass_skeleton();
            // }

            // $this->buildClass_implements();
            // $this->buildClass_table();
            // $this->buildClass_perPage();

            // $this->buildClass_attributes();
            // $this->buildClass_casts();
            // $this->buildClass_fillable();

            // // Relationships
            // $this->buildClass_HasMany();
            // $this->buildClass_HasOne();

            // $this->buildClass_uses($name);

            $this->applyConfigurationToSearch();

            // if ($this->searches['use']) {
            //     $this->searches['use'] .= PHP_EOL;
            // }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$config' => $config,
        //     // '$config_columns' => $config_columns,
        //     // '$this->searches[table]' => $this->searches['table'],
        //     '$this->searches' => $this->searches,
        // ]);
        return parent::buildClass($name);
    }

    /**
     * Create a factory file for the model.
     *
     * @see FactoryMakeCommand
     */
    protected function createFactory(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $params = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Factory')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--model-file' => $file,
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $params['--model-file'] = $file;
        }

        $this->call('playground:make:factory', $params);
    }

    /**
     * Create a migration file for the model.
     *
     * @see MigrationMakeCommand
     */
    protected function createMigration(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $params = [
            'name' => $this->c->name(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--model-file' => $file,
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $params['--model-file'] = $file;
        }

        $this->call('playground:make:migration', $params);

        // $force = $this->hasOption('force') && $this->option('force');
        // $model = $this->hasOption('model') ? $this->option('model') : '';
        // $module = $this->hasOption('module') ? $this->option('module') : '';
        // $name = $this->argument('name');
        // // $name = $this->qualifiedName;
        // $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        // $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        // $package = $this->hasOption('package') ? $this->option('package') : '';

        // $table = Str::snake(Str::pluralStudly(class_basename($this->qualifiedName)));
        // // dump([
        // //     '__METHOD__' => __METHOD__,
        // //     // '$this->argument(name)' => $this->argument('name'),
        // //     '$this->qualifiedName' => $this->qualifiedName,
        // // ]);

        // // if ($this->option('pivot')) {
        // //     $table = Str::singular($table);
        // // }

        // $file = $this->option('file');

        // // if ($this->option('skeleton')) {
        // //     if (empty($file) && $this->path_to_configuration) {
        // //         $file = $this->path_to_configuration;
        // //     }
        // // }

        // if (empty($model)) {
        //     $model = $this->c->model();
        // }
        // if (empty($name)) {
        //     $name = $this->c->name();
        // }
        // if (empty($organization)) {
        //     $organization = $this->c->organization();
        // }

        // $params = [
        //     'name' => $name,
        //     '--namespace' => $namespace,
        //     '--force' => $force,
        //     '--package' => $package,
        //     '--organization' => $organization,
        //     '--model' => $model,
        //     '--module' => $module,
        //     '--file' => $file,
        //     '--type' => $this->c->type(),
        // ];

        // // if (empty($params['--file'])) {
        // //     $params['name'] = $this->qualifiedName;
        // // }

        // // if ($this->hasOption('force') && $this->option('force')) {
        // //     $params['--force'] = true;
        // // }

        // // dump([
        // //     '__METHOD__' => __METHOD__,
        // //     '$this->c' => $this->c,
        // //     '$this->searches' => $this->searches,
        // //     '$this->qualifiedName' => $this->qualifiedName,
        // //     '$table' => $table,
        // //     '$params' => $params,
        // // ]);
        // $this->call('playground:make:migration', $params);

        // // $this->call('playground:make:migration', [
        // //     // 'name' => "create_{$table}_table",
        // //     'name' => $this->qualifiedName,
        // //     // '--create' => $table,
        // // ]);
    }

    /**
     * Create a controller for the model.
     *
     * @see PolicyMakeCommand
     * @see SeederMakeCommand
     * @see TestMakeCommand
     */
    protected function createController(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $params = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Controller')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if ($this->option('api')) {
            $params['--api'] = true;
        } elseif ($this->option('resource')) {
            $params['--resource'] = true;
        } else {
            if (in_array($this->c->type(), [
                'resource',
                'playground-resource',
            ])) {
                $params['--resource'] = true;
            } elseif (in_array($this->c->type(), [
                'api',
                'playground-api',
            ])) {
                $params['--api'] = true;
            }
        }
        if ($this->c->requests()) {
            $params['--requests'] = true;
        }

        if (! empty($file) && is_string($file)) {
            $params['--model-file'] = $file;
        }

        $this->call('playground:make:controller', $params);

        // $controller = Str::studly(class_basename($this->qualifiedName));

        // // $modelName = $this->qualifyClass($this->getNameInput());

        // $params = [
        //     '--file' => $this->option('file'),
        // ];

        // if (empty($params['--file'])) {
        //     $params['name'] = "{$controller}Controller";
        //     // $params['--model'] = $this->option('resource') || $this->option('api') ? $modelName : null;
        //     $params['--model'] = $this->qualifiedName;
        //     if ($this->option('api')) {
        //         $params['--api'] = true;
        //     } elseif ($this->option('resource')) {
        //         $params['--resource'] = true;
        //     } else {
        //         if (in_array($this->c->type(), [
        //             'resource',
        //             'playground-resource',
        //         ])) {
        //             $params['--resource'] = true;
        //         } elseif (in_array($this->c->type(), [
        //             'api',
        //             'playground-api',
        //         ])) {
        //             $params['--api'] = true;
        //         }
        //     }
        //     $params['--requests'] = $this->c->requests();
        // }

        // if ($this->hasOption('force') && $this->option('force')) {
        //     $params['--force'] = true;
        // }

        // $this->call('playground:make:controller', $params);

        // // $this->call('playground:make:controller', array_filter([
        // //     'name' => "{$controller}Controller",
        // //     '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
        // //     '--api' => $this->option('api'),
        // //     '--requests' => $this->option('requests') || $this->option('all'),
        // // ]));

        // // $force = $this->hasOption('force') && $this->option('force');
        // // $file = $this->option('file');

        // // // $seeder = Str::studly(class_basename($this->argument('name')));
        // // $seeder = Str::studly(class_basename($this->qualifiedName));

        // // $params = [
        // //     'name' => sprintf('%1$sSeeder', Str::studly(class_basename($this->qualifiedName))),
        // //     '--namespace' => $this->c->namespace(),
        // //     '--force' => $force,
        // //     '--package' => $this->c->package(),
        // //     '--organization' => $this->c->organization(),
        // //     '--model' => $this->c->model(),
        // //     '--module' => $this->c->module(),
        // //     '--type' => $this->c->type(),
        // // ];

        // // if (! empty($file) && is_string($file)) {
        // //     $params['--model-file'] = $file;
        // // }

        // // $this->call('playground:make:controller', $params);

    }

    /**
     * Create a policy file for the model.
     *
     * @see PolicyMakeCommand
     */
    protected function createPolicy(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $params = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Policy')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $params['--model-file'] = $file;
        }

        $this->call('playground:make:policy', $params);
    }

    /**
     * Create a seeder file for the model.
     *
     * @see SeederMakeCommand
     */
    protected function createSeeder(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $params = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Seeder')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $params['--model-file'] = $file;
        }

        $this->call('playground:make:seeder', $params);
    }

    /**
     * Create a test file for the model.
     *
     * @return void
     */
    protected function createTest()
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $params = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Policy')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $params['--model-file'] = $file;
        }

        $params['--suite'] = 'unit';
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     // '$this->searches' => $this->searches,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     // '$table' => $table,
        //     '$params' => $params,
        // ]);
        $this->call('playground:make:test', $params);

        $params['--suite'] = 'feature';
        $this->call('playground:make:test', $params);

        // $this->c->setOptions([
        //     'test' => true,
        // ]);

        // $force = $this->hasOption('force') && $this->option('force');
        // $model = $this->hasOption('model') ? $this->option('model') : '';
        // $module = $this->hasOption('module') ? $this->option('module') : '';
        // $name = $this->argument('name');
        // // $name = $this->qualifiedName;
        // $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        // $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        // $package = $this->hasOption('package') ? $this->option('package') : '';

        // // $table = Str::snake(Str::pluralStudly(class_basename($this->qualifiedName)));
        // // dd([
        // //     '__METHOD__' => __METHOD__,
        // //     // '$this->argument(name)' => $this->argument('name'),
        // //     '$this->qualifiedName' => $this->qualifiedName,
        // // ]);

        // // if ($this->option('pivot')) {
        // //     $table = Str::singular($table);
        // // }

        // $file = $this->option('file');

        // // if ($this->option('skeleton')) {
        // //     if (empty($file) && $this->path_to_configuration) {
        // //         $file = $this->path_to_configuration;
        // //     }
        // // }

        // if (empty($package)) {
        //     $package = $this->c->package();
        // }
        // if (empty($namespace)) {
        //     $namespace = $this->c->namespace();
        // }
        // if (empty($model)) {
        //     $model = $this->c->model();
        // }
        // if (empty($name)) {
        //     $name = $this->c->name();
        // }
        // if (empty($organization)) {
        //     $organization = $this->c->organization();
        // }

        // $params = [
        //     'name' => $name,
        //     '--namespace' => $namespace,
        //     '--force' => $force,
        //     '--package' => $package,
        //     '--organization' => $organization,
        //     '--model' => $model,
        //     '--module' => $module,
        //     '--model-file' => $file,
        //     '--type' => $this->c->type(),
        // ];

        // // if (empty($params['--file'])) {
        // //     $params['name'] = $this->qualifiedName;
        // // }

        // // if ($this->hasOption('force') && $this->option('force')) {
        // //     $params['--force'] = true;
        // // }

        // $params['--suite'] = 'unit';
        // // dd([
        // //     '__METHOD__' => __METHOD__,
        // //     // '$this->c' => $this->c,
        // //     // '$this->searches' => $this->searches,
        // //     '$this->qualifiedName' => $this->qualifiedName,
        // //     // '$table' => $table,
        // //     '$params' => $params,
        // // ]);
        // $this->call('playground:make:test', $params);

        // $params['--suite'] = 'feature';
        // $this->call('playground:make:test', $params);

        // $this->c->setOptions([
        //     'test' => true,
        // ]);

        // // $this->call('playground:make:test', [
        // //     // 'name' => "create_{$table}_table",
        // //     'name' => $this->qualifiedName,
        // //     // '--create' => $table,
        // // ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $template = 'laravel/model.stub';

        if ($this->c->type() === 'abstract') {
            $template = 'model/abstract.stub';
        } elseif ($this->c->type() === 'model') {
            $template = 'model/model.stub';
        } elseif (in_array($this->c->type(), [
            'api',
            'resource',
            'playground-api',
            'playground-resource',
        ])) {
            $template = 'model/resource.stub';
        } elseif ($this->c->type() === 'pivot') {
            $template = 'laravel/model.pivot.stub';

            return $this->resolveStubPath('laravel/model.pivot.stub');
        } elseif ($this->c->type() === 'morph-pivot') {
            $template = 'laravel/model.morph-pivot.stub';
        }

        return $this->resolveStubPath($template);
    }

    // /**
    //  * Resolve the fully-qualified path to the stub.
    //  *
    //  * @param  string  $stub
    //  * @return string
    //  */
    // protected function resolveStubPath($stub)
    // {
    //     return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
    //                     ? $customPath
    //                     : __DIR__.$stub;
    // }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->parseClassInput($rootNamespace).'\\Models';
        // return $rootNamespace.'\\Models';
        // return is_dir(app_path('Models')) ? $rootNamespace.'\\Models' : $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        return [
            ['all',             'a',  InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, policy, resource controller, and form request classes for the model'],
            ['controller',      'c',  InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['factory',         'f',  InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['force',           null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['skeleton',        null, InputOption::VALUE_NONE, 'Create the skeleton for the model'],
            ['test',            null, InputOption::VALUE_NONE, 'Create the unit and feature tests for the model'],
            ['migration',       'm',  InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['morph-pivot',     null, InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom polymorphic intermediate table model'],
            ['policy',          null, InputOption::VALUE_NONE, 'Create a new policy for the model'],
            ['seed',            's',  InputOption::VALUE_NONE, 'Create a new seeder for the model'],
            ['pivot',           'p',  InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
            ['resource',        'r',  InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
            ['api',             null, InputOption::VALUE_NONE, 'Indicates if the generated controller should be an API resource controller'],
            ['requests',        'R',  InputOption::VALUE_NONE, 'Create new form request classes and use them in the resource controller'],
            ['module',          null, InputOption::VALUE_OPTIONAL, 'The module that the '.strtolower($this->type).' belongs to'],
            ['namespace',       null, InputOption::VALUE_OPTIONAL, 'The namespace of the '.strtolower($this->type)],
            ['type',            null, InputOption::VALUE_OPTIONAL, 'The configuration type of the '.strtolower($this->type)],
            ['organization',    null, InputOption::VALUE_OPTIONAL, 'The organization of the '.strtolower($this->type)],
            ['package',         null, InputOption::VALUE_OPTIONAL, 'The package of the '.strtolower($this->type)],
            ['class',           null, InputOption::VALUE_OPTIONAL, 'The class name of the '.strtolower($this->type)],
            ['file',            null, InputOption::VALUE_OPTIONAL, 'The configuration file of the '.strtolower($this->type)],
            ['table',           null, InputOption::VALUE_OPTIONAL, 'The schema table name of the '.strtolower($this->type)],
        ];
    }

    // /**
    //  * Interact further with the user if they were prompted for missing arguments.
    //  *
    //  * @return void
    //  */
    // protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    // {
    //     $name = $this->getNameInput();
    //     if (($name && $this->isReservedName($name)) || $this->didReceiveOptions($input)) {
    //         return;
    //     }

    //     collect(multiselect('Would you like any of the following?', [
    //         'seed' => 'Database Seeder',
    //         'factory' => 'Factory',
    //         'requests' => 'Form Requests',
    //         'migration' => 'Migration',
    //         'policy' => 'Policy',
    //         'resource' => 'Resource Controller',
    //     ]))->each(fn ($option) => $input->setOption(is_string($option) ? $option : '', true));
    // }
}
