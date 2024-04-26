<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Building;
use Playground\Stub\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Stub\Configuration\Migration as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\MigrationMakeCommand
 */
#[AsCommand(name: 'playground:make:migration')]
class MigrationMakeCommand extends GeneratorCommand
{
    use Building\Concerns\BuildUses;
    use Building\Migration\BuildColumns;
    use Building\Migration\BuildDates;
    use Building\Migration\BuildFlags;
    use Building\Migration\BuildIds;
    use Building\Migration\BuildJson;
    use Building\Migration\BuildMatrix;
    use Building\Migration\BuildPermissions;
    use Building\Migration\BuildPrimary;
    use Building\Migration\BuildStatus;
    use Building\Migration\BuildUi;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    protected string $path_destination_folder = 'database/migrations';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:migration';

    protected bool $qualifiedNameStudly = false;

    // /**
    //  * The console command signature.
    //  *
    //  * @var string
    //  */
    // protected $signature = 'playground:make:migration {name : The name of the migration}
    //     {--create= : The table to be created}
    //     {--table= : The table to migrate}
    //     {--path= : The location where the migration file should be created}
    //     {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
    //     {--fullpath : Output the full path of the migration (Deprecated)}';

    // /**
    //  * Get the console command arguments.
    //  *
    //  * @return array
    //  */
    // protected function getOptions()
    // {
    //     $options = parent::getOptions();

    //     $options[] = ['create', null, InputOption::VALUE_OPTIONAL, 'The table to be created'];
    //     $options[] = ['table', null, InputOption::VALUE_OPTIONAL, 'The table to migrate'];

    //     return $options;
    // }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['table', null, InputOption::VALUE_OPTIONAL, 'The schema table name of the migration'];
        $options[] = ['create', null, InputOption::VALUE_NONE, 'Make a create migration'];
        $options[] = ['update', null, InputOption::VALUE_NONE, 'Make an update migration'];

        return $options;
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * @var array<int, mixed>
     */
    protected array $columns = [];

    // const CONFIGURATION = [
    //     'package' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'name' => '',
    //     'namespace' => '',
    //     // 'modelspace' => '',
    //     'organization' => '',
    //     'type' => '',
    //     'class' => '',
    //     'table' => '',
    //     'extends' => '',
    //     'implements' => [],
    //     'HasMany' => [],
    //     'implements' => [],
    //     'create' => [],
    // ];

    const SEARCH = [
        'use' => '',
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => '',
        'organization' => '',
        'table' => '',
        'table_primary' => '',
        'table_ids' => '',
        'table_timestamps' => '',
        'table_softDeletes' => '',
        'table_dates' => '',
        'table_permissions' => '',
        'table_status' => '',
        'table_matrix' => '',
        'table_flags' => '',
        'table_columns' => '',
        'table_entity' => '',
        'table_ui' => '',
        'table_json' => '',
        // 'attributes' => '',
        // 'casts' => '',
        // 'fillable' => '',
        // 'perPage' => '',
        // 'HasMany' => '',
        // 'HasOne' => '',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->columns = [];

        return parent::handle();
    }

    public function prepareOptions(): void
    {
        $options = $this->options();

        $type = $this->getConfigurationType();

        if ($this->hasOption('create') && $this->option('create')) {
            $this->c->setOptions([
                'create' => true,
            ]);
        } elseif ($this->hasOption('update') && $this->option('update')) {
            $this->c->setOptions([
                'update' => true,
            ]);
        }

        $this->initModel($this->c->skeleton());

        $table = $this->c->table();
        $name = $this->c->name();

        if (! $table) {

            if ($this->hasOption('table')
                && $this->option('table')
                && is_string($this->option('table'))
            ) {
                $table = $this->option('table');
                if (! preg_match('/^[a-z][a-z0-9_]+$/i', $table)) {
                    $this->components->error(sprintf(
                        'Invalid table name [%s], using argument [%s] to generate',
                        $table,
                        $name
                    ));
                    $table = Str::snake(Str::pluralStudly(class_basename($name)));
                }
            } else {
                $table = $this->model?->table();
                if (! $table) {
                    $table = Str::snake(Str::pluralStudly(class_basename($name)));
                }
            }
        } else {
            if (! preg_match('/^[a-z][a-z0-9_]+$/i', $table)) {
                $this->components->error(sprintf(
                    'Invalid table name [%s] in configuration, using name [%s] to generate',
                    $table,
                    $name
                ));
                $table = Str::snake(Str::pluralStudly(class_basename($name)));
            }
        }

        $this->c->setOptions([
            'table' => $table,
        ]);

        if (! $this->c->table()) {
            throw new \RuntimeException('A table is required.');
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$options' => $options,
        //     '$type' => $type,
        //     // '$this->model' => $this->model,
        //     '!empty($this->model)' => !empty($this->model),
        //     // '$this->c' => $this->c,
        //     '$this->c->class()' => $this->c->class(),
        //     '$this->c->table()' => $this->c->table(),
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     */
    protected function qualifyClass($name): string
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$this->c->class()' => $this->c->class(),
        //     '$this->c->table()' => $this->c->table(),
        // ]);

        $class = $this->c->class();
        $table = $this->c->table();

        if (! $class) {
            $class = $this->model?->create()?->migration();
        }

        if (! $class) {
            $class = sprintf(
                '%1$s_%2$s_%3$s_%4$s_table',
                date('Y_m_d'),
                '000000',
                'create',
                $table
            );
        }

        $this->c->setOptions([
            'class' => $class,
        ]);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$his->arguments()' => $this->arguments(),
        //     // '$his->options()' => $this->options(),
        //     // '$this->c' => $this->c,
        //     '$this->c->class()' => $this->c->class(),
        //     '$this->c->table()' => $this->c->table(),
        //     // '$this->searches' => $this->searches,
        //     '$class' => $class,
        //     '$name' => $name,
        //     '$table' => $table,
        // ]);

        return $this->c->class();
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
            'model',
            'playground-model',
            'resource',
            'playground-resource',
            'api',
            'playground-api',
        ])) {
            $this->buildClass_primary();
            $this->buildClass_ids();
            $this->buildClass_timestamps();
            $this->buildClass_softDeletes();
            $this->buildClass_dates();
            $this->buildClass_permissions();
            $this->buildClass_status();
            $this->buildClass_matrix();
            $this->buildClass_flags();
            $this->buildClass_columns();
            $this->buildClass_ui();
            $this->buildClass_json();

            // // Relationships
            // $this->buildClass_HasMany();
            // $this->buildClass_HasOne();

            $this->applyConfigurationToSearch();
            $this->buildClass_uses($name);

        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$his->arguments()' => $this->arguments(),
        //     '$his->options()' => $this->options(),
        //     '$this->c' => $this->c->toArray(),
        //     '$this->searches' => $this->searches,
        //     '$this->model' => $this->model,
        // ]);

        return parent::buildClass($name);
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $template = 'laravel/migration.stub';

        if ($this->c->create()) {
            $template = 'model/migration.create.stub';
        } elseif ($this->c->update()) {
            $template = 'model/migration.update.stub';
        }

        return $this->resolveStubPath($template);
    }

    // /**
    //  * Prompt for missing input arguments using the returned questions.
    //  *
    //  * @return array
    //  */
    // protected function promptForMissingArgumentsUsing()
    // {
    //     return [
    //         'name' => ['What should the migration be named?', 'E.g. create_flights_table'],
    //     ];
    // }
}
