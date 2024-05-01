<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Support\Str;
// use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;
use Playground\Stub\Building;
use Playground\Stub\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
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
    use Building\Concerns\BuildImplements;
    use Building\Concerns\BuildUses;
    use Building\Model\Analysis;
    use Building\Model\BuildAttributes;
    use Building\Model\BuildCasts;
    use Building\Model\BuildCreate;
    use Building\Model\BuildDocBlock;
    use Building\Model\BuildFillable;
    use Building\Model\BuildPerPage;
    use Building\Model\BuildRelationships;
    use Building\Model\BuildTable;
    use Building\Model\MakeCommands;
    use Building\Model\MakeSkeleton;
    use Building\Model\Skeleton\MakeColumns;
    use Building\Model\Skeleton\MakeDates;
    use Building\Model\Skeleton\MakeFlags;
    use Building\Model\Skeleton\MakeIds;
    use Building\Model\Skeleton\MakeJson;
    use Building\Model\Skeleton\MakeMatrix;
    use Building\Model\Skeleton\MakePermissions;
    use Building\Model\Skeleton\MakeStatus;
    use Building\Model\Skeleton\MakeUi;
    use Building\Model\Skeleton\MakeUnique;
    // use Building\Model\BuildModel;

    // use Concerns\CreatingModels;
    use CreatesMatchingTest;
    // use Traits\ModelRelationshipsMakeTrait;
    // use Traits\ModelSkeletonMakeTrait;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

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
        'docblock' => '',
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

    protected bool $isApi = false;

    protected bool $isResource = false;

    protected bool $replace = false;

    public function prepareOptions(): void
    {
        $options = $this->options();

        $type = $this->getConfigurationType();
        if (! $type) {
            $this->c->setOptions([
                'type' => 'model',
            ]);
        }

        if ($this->hasOption('all') && $this->option('all')) {

            $this->c->setOptions([
                'controller' => true,
                'factory' => true,
                'migration' => true,
                'policy' => true,
                'requests' => true,
                // 'resources' => true,
                'seed' => true,
                'test' => true,
                // 'transformers' => true,
            ]);
        }

        $this->isApi = $this->hasOption('api') && $this->option('api');
        $this->isResource = $this->hasOption('resource') && $this->option('resource');

        if ($this->isApi || $this->isResource) {
            $this->c->setOptions([
                'controller' => true,
                'factory' => true,
                'migration' => true,
                'policy' => false,
                'requests' => false,
                'resources' => false,
                'seed' => true,
                'test' => true,
                'transformers' => false,
            ]);
        }

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

        if ($this->hasOption('playground') && $this->option('playground')) {
            $this->c->setOptions([
                'playground' => true,
            ]);
        }

        if ($this->hasOption('requests') && $this->option('requests')) {
            $this->c->setOptions([
                'requests' => true,
            ]);
        }

        if ($this->hasOption('resources') && $this->option('resources')) {
            $this->c->setOptions([
                'resources' => true,
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

        if ($this->hasOption('transformers') && $this->option('transformers')) {
            $this->c->setOptions([
                'transformers' => true,
            ]);
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

        if ($this->hasOption('replace') && $this->option('replace')) {
            $this->replace = true;
        }
    }

    public function finish(): ?bool
    {
        $this->saveConfiguration();

        if ($this->c->factory()) {
            $this->createFactory();
        }

        if ($this->c->migration()) {
            $this->createMigration();
        }

        if ($this->c->seed()) {
            $this->createSeeder();
        }

        if ($this->c->controller()) {
            $this->createController();
        }

        if ($this->c->policy()) {
            $this->createPolicy();
        }

        // if ($this->c->resources()) {
        //     $this->createResources();
        // }

        if ($this->c->test()) {
            $this->createTest();
        }

        // if ($this->c->transformers()) {
        //     $this->createTransformers();
        // }

        $this->saveConfiguration();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c' => $this->c,
        //     // '$this->c' => $this->c->toArray(),
        //     // '$this->searches' => $this->searches,
        //     // '$this->analyze' => $this->analyze,
        // ]);

        return $this->return_status;
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
        // if (in_array($this->c->type(), [
        //     'abstract',
        //     'model',
        //     'morph-pivot',
        //     'pivot',
        //     'playground-abstract',
        //     'playground',
        // ])) {
        $this->searches['use'] = '';
        $this->searches['use_class'] = '';

        if ($this->c->skeleton()) {
            $this->buildClass_skeleton();
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     '$this->c' => $this->c->toArray(),
        //     '$this->searches' => $this->searches,
        //     '$this->analyze' => $this->analyze,
        // ]);
        $this->buildClass_docblock();
        $this->buildClass_implements();
        $this->buildClass_table_property();
        $this->buildClass_perPage();

        $this->buildClass_attributes();
        $this->buildClass_fillable();
        $this->buildClass_casts();

        // // Relationships
        $this->buildClass_HasOne();
        $this->buildClass_HasMany();

        $this->buildClass_uses($name);

        // $this->c->apply();
        $this->applyConfigurationToSearch();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        // ]);

        return parent::buildClass($name);
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
            $template = 'model/model.stub';
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
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'abstract',
        'model',
        'morph-pivot',
        'pivot',
        'playground',
    ];

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
            ['playground',      null, InputOption::VALUE_NONE, 'Create a Playground model'],
            ['force',           null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['skeleton',        null, InputOption::VALUE_NONE, 'Create the skeleton for the model'],
            ['replace',         null, InputOption::VALUE_NONE, 'Replace the attributes, casts, fillable options when using skeleton for the model'],
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

    /**
     * Create the matching test case if requested.
     *
     * @param  string  $path
     * @return bool
     */
    protected function handleTestCreation($path)
    {
        if (! $this->option('test') && ! $this->option('pest') && ! $this->option('phpunit')) {
            return false;
        }

        $this->createTest();

        return true;
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab()->toString(),
            Str::of($this->getType())->kebab()->toString(),
        );
    }
}
