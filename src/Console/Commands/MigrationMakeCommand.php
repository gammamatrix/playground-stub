<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Building;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Migration as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\MigrationMakeCommand
 */
#[AsCommand(name: 'playground:make:migration')]
class MigrationMakeCommand extends GeneratorCommand
{
    use Building\Migration\BuildIds;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

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

        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

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
        if (! empty($this->c->table())
            && is_string($this->c->table())
        ) {
            $table = $this->c->table();
            if (! preg_match('/^[a-z][a-z0-9_]+$/i', $table)) {
                $this->components->error(sprintf(
                    'Invalid table name [%s] in configuration',
                    $table
                ));
                $table = Str::snake(Str::pluralStudly(class_basename($table)));
            }
        } elseif ($this->hasOption('table')
            && $this->option('table')
            && is_string($this->option('table'))
        ) {
            $table = $this->option('table');
            if (! preg_match('/^[a-z][a-z0-9_]+$/i', $table)) {
                $this->components->error(sprintf(
                    'Invalid table name [%s] using argument [%s] to generate',
                    $table,
                    $name
                ));
                $table = Str::snake(Str::pluralStudly(class_basename($name)));
            }
        } else {
            $table = Str::snake(Str::pluralStudly(class_basename($name)));
        }

        if ($this->c->class()) {
            $class = $this->c->class();
        } else {
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
            // $this->buildClass_entity();
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
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$his->arguments()' => $this->arguments(),
        //     '$his->options()' => $this->options(),
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     '$this->model' => $this->model,
        // ]);

        return parent::buildClass($name);
    }

    protected function buildClass_primary(): void
    {
        $primary = $this->model?->create()?->primary();

        $this->searches['table_primary'] = PHP_EOL;

        $this->searches['table_primary'] .= sprintf(
            '%1$s// Primary key',
            str_repeat(' ', 12)
        );

        $this->searches['table_primary'] .= PHP_EOL.PHP_EOL;

        if ($primary === 'uuid') {
            $this->searches['table_primary'] .= sprintf(
                '%1$s$table->uuid(\'id\')->primary();',
                str_repeat(' ', 12)
            );
        } elseif ($primary === 'increments') {
            $this->searches['table_primary'] .= sprintf(
                '%1$s$table->id();',
                str_repeat(' ', 12)
            );
        } else {
            $this->searches['table_primary'] = '';
        }
    }

    protected function buildClass_timestamps(): void
    {
        if (! $this->model?->create()?->timestamps()) {
            return;
        }

        $this->searches['table_timestamps'] = PHP_EOL.PHP_EOL;

        $this->searches['table_timestamps'] .= sprintf(
            '%1$s// Dates',
            str_repeat(' ', 12)
        );

        $this->searches['table_timestamps'] .= PHP_EOL.PHP_EOL;

        $this->searches['table_timestamps'] .= sprintf(
            '%1$s$table->timestamps();',
            str_repeat(' ', 12)
        );
    }

    protected function buildClass_softDeletes(): void
    {
        if (! $this->model?->create()?->softDeletes()) {
            return;
        }

        $this->searches['table_softDeletes'] = PHP_EOL.PHP_EOL;

        $this->searches['table_softDeletes'] .= sprintf(
            '%1$s$table->softDeletes();',
            str_repeat(' ', 12)
        );
    }

    protected function buildClass_dates(): void
    {
        $dates = $this->model?->create()?->dates();
        if (! $dates) {
            return;
        }

        $this->searches['table_dates'] .= PHP_EOL;

        $i = 0;
        foreach ($dates as $attribute => $meta) {
            $column = '';

            $column .= sprintf(
                '%1$s%2$s$table->dateTime(\'%3$s\')',
                PHP_EOL,
                str_repeat(' ', 12),
                $attribute
            );

            if ($meta->nullable()) {
                // $column .= '->nullable()->default(null)';
                $column .= '->nullable()';
            }

            if ($meta->index()) {
                $column .= '->index()';
            }

            $column .= ';';

            $this->searches['table_dates'] .= $column;
            $i++;
        }
    }

    protected function buildClass_permissions(): void
    {
        $permissions = $this->model?->create()?->permissions();
        if (! $permissions) {
            return;
        }

        $this->searches['table_permissions'] = PHP_EOL.PHP_EOL;

        $this->searches['table_permissions'] .= sprintf(
            '%1$s// Permissions',
            str_repeat(' ', 12)
        );

        $this->searches['table_permissions'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_permissions'] .= PHP_EOL;
        // }

        $this->buildClass_column_group(
            'table_permissions',
            $permissions
        );
    }

    protected function buildClass_ui(): void
    {
        $ui = $this->model?->create()?->ui();
        if (! $ui) {
            return;
        }

        $this->searches['table_ui'] = PHP_EOL.PHP_EOL;

        $this->searches['table_ui'] .= sprintf(
            '%1$s// UI',
            str_repeat(' ', 12)
        );

        $this->searches['table_ui'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_permissions'] .= PHP_EOL;
        // }

        $this->buildClass_column_group(
            'table_ui',
            $ui
        );
    }

    protected function buildClass_flags(): void
    {
        $flags = $this->model?->create()?->flags();
        if (! $flags) {
            return;
        }

        $this->searches['table_flags'] = PHP_EOL.PHP_EOL;

        $this->searches['table_flags'] .= sprintf(
            '%1$s// Flags',
            str_repeat(' ', 12)
        );

        $this->searches['table_flags'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_permissions'] .= PHP_EOL;
        // }

        $this->buildClass_column_group(
            'table_flags',
            $flags
        );
    }

    protected function buildClass_status(): void
    {
        $status = $this->model?->create()?->status();
        if (! $status) {
            return;
        }

        $this->searches['table_status'] = PHP_EOL.PHP_EOL;

        $this->searches['table_status'] .= sprintf(
            '%1$s// Status',
            str_repeat(' ', 12)
        );

        $this->searches['table_status'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_permissions'] .= PHP_EOL;
        // }

        $this->buildClass_column_group(
            'table_status',
            $status
        );
    }

    protected function buildClass_columns(): void
    {
        $columns = $this->model?->create()?->columns();
        if (! $columns) {
            return;
        }

        $this->searches['table_columns'] = PHP_EOL.PHP_EOL;

        $this->searches['table_columns'] .= sprintf(
            '%1$s// Strings',
            str_repeat(' ', 12)
        );

        $this->searches['table_columns'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_permissions'] .= PHP_EOL;
        // }

        $this->buildClass_column_group(
            'table_columns',
            $columns
        );
    }

    /**
     * @param array<string, mixed> $attributes
     * @param array<int, string> $allowed
     */
    protected function buildClass_column_group(string $group, array $attributes, array $allowed = []): void
    {
        $i = 0;
        foreach ($attributes as $attribute => $meta) {

            $meta = is_array($meta) ? $meta : [];
            if (in_array($attribute, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $attribute,
                    $group
                ));

                continue;
            }

            $this->columns[] = $attribute;

            $type = empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'];

            if (in_array($type, [
                'JSON_OBJECT',
                'JSON_ARRAY',
            ])) {
                $this->searches[$group] .= $this->buildClass_json_column($attribute, $meta, $group);
            } else {
                $this->searches[$group] .= $this->buildClass_column($attribute, $meta, $group);
            }

            $i++;
        }
    }

    /**
     * @param array<string, mixed> $meta
     */
    protected function buildClass_column(string $attribute, array $meta, string $group): string
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$attribute' => $attribute,
        //     '$meta' => $meta,
        //     '$group' => $group,
        // ]);
        $allowed = [
            'uuid',
            'string',
            'mediumText',
            'boolean',
            'integer',
            'bigInteger',
            'mediumInteger',
            'smallInteger',
            'tinyInteger',
            'dateTime',
            'decimal',
            'float',
            'double',
        ];

        $type = empty($meta['type']) || ! is_string($meta['type']) ? '' : $meta['type'];

        if (! $type || ! in_array($meta['type'], $allowed)) {
            $this->components->error(sprintf(
                '[%s]: Invalid column [%s] type: [%s] ',
                $group,
                $attribute,
                $type
            ));

            return sprintf(
                '%1$s%2$s// SKIPPED: invalid column [%3$s] type: %4$s',
                PHP_EOL,
                str_repeat(' ', 12),
                $attribute,
                $type
            );
        }

        if (in_array($type, [
            'decimal',
            'float',
            'double',
        ])) {
            $column = sprintf(
                '%1$s%2$s$table->%3$s(\'%4$s\', %5$d, %6$d)',
                PHP_EOL,
                str_repeat(' ', 12),
                $type,
                $attribute,
                empty($meta['precision']) || ! is_numeric($meta['precision']) || $meta['precision'] < 1 ? 8 : intval($meta['precision']),
                empty($meta['scale']) || ! is_numeric($meta['scale']) || $meta['scale'] < 1 ? 2 : intval($meta['scale'])
            );
        } else {
            $column = sprintf(
                '%1$s%2$s$table->%3$s(\'%4$s\')',
                PHP_EOL,
                str_repeat(' ', 12),
                $type,
                $attribute
            );
        }

        if (! empty($meta['nullable'])) {
            // $column .= '->nullable()->default(null)';
            $column .= '->nullable()';
        }

        if (array_key_exists('default', $meta)) {
            if (is_null($meta['default'])) {
                $column .= '->default(null)';
            } elseif (is_bool($meta['default'])) {
                $column .= sprintf('->default(%1$d)', $meta['default'] ? 1 : 0);
            } elseif (is_numeric($meta['default'])) {
                $column .= sprintf('->default(%1$d)', $meta['default']);
            } elseif (is_string($meta['default'])) {
                $column .= sprintf('->default(\'%1$s\')', $meta['default']);
            }
        }

        if (! empty($meta['unsigned'])) {
            $column .= '->unsigned()';
        }

        if (! empty($meta['index'])) {
            $column .= '->index()';
        }

        $column .= ';';

        return $column;
    }

    /**
     * @param array<string, mixed> $meta
     */
    protected function buildClass_json_column(string $attribute, array $meta, string $group): string
    {
        $allowed = [
            'JSON_OBJECT',
            'JSON_ARRAY',
        ];

        $type = empty($meta['type'])
            || ! is_string($meta['type'])
            || ! in_array($meta['type'], $allowed)
            ? '' : $meta['type'];

        if (! $type) {
            $this->components->error(sprintf(
                '[%s]: Invalid column [%s] type: %s',
                $group,
                $attribute,
                $type
            ));

            return sprintf(
                '%1$s%2$s// SKIPPED: invalid column [%3$s] type: [%4$s]',
                PHP_EOL,
                str_repeat(' ', 12),
                $attribute,
                $type
            );
        }

        $column = '';

        $column .= sprintf(
            '%1$s%2$s$table->json(\'%3$s\')',
            PHP_EOL,
            str_repeat(' ', 12),
            $attribute
        );

        if (! empty($meta['nullable'])) {
            // $column .= '->nullable()->default(null)';
            $column .= '->nullable()';
        }

        $column .= sprintf(
            '->default(new Expression(\'(%1$s())\'))',
            $type
        );

        if (! empty($meta['comment']) && is_string($meta['comment'])) {
            $column .= sprintf('->comment(\'%1$s\')', addslashes($meta['comment']));
        }

        $column .= ';';

        return $column;
    }

    protected function buildClass_json(): void
    {
        $json = $this->model?->create()?->json();
        if (! $json) {
            return;
        }
        $this->buildClass_uses_add('Illuminate\Database\Query\Expression');
        // $this->searches['use'] .= 'use Illuminate\Database\Query\Expression;';
        // $this->searches['use'] .= PHP_EOL;

        $allowed = [
            'JSON_OBJECT',
            'JSON_ARRAY',
        ];

        $this->searches['table_json'] = PHP_EOL.PHP_EOL;

        $this->searches['table_json'] .= sprintf(
            '%1$s// JSON',
            str_repeat(' ', 12)
        );

        $this->searches['table_json'] .= PHP_EOL;

        $i = 0;
        foreach ($json as $attribute => $meta) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$attribute' => $attribute,
            //     '$meta' => $meta,
            // ]);

            // $type = empty($meta['type'])
            //     || ! is_string($meta['type'])
            //     || ! in_array($meta['type'], $allowed)
            // ? '' : $meta['type'];

            $this->searches['table_json'] .= $this->buildClass_json_column(
                $attribute,
                $meta->properties(),
                'json'
            );
            // $column = '';

            // $column .= sprintf(
            //     '%1$s%2$s$table->json(\'%3$s\')',
            //     PHP_EOL,
            //     str_repeat(' ', 12),
            //     $attribute
            // );

            // if (! empty($meta['nullable'])) {
            //     // $column .= '->nullable()->default(null)';
            //     $column .= '->nullable()';
            // }

            // if (! empty($type)) {
            //     $column .= sprintf(
            //         '->default(new Expression(\'(%1$s())\'))',
            //         $type
            //     );
            // }

            // if (! empty($meta['comment']) && is_string($meta['comment'])) {
            //     $column .= sprintf('->comment(\'%1$s\')', addslashes($meta['comment']));
            // }
            // $column .= ';';

            // $this->searches['table_json'] .= $column;
            $i++;
        }
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
    //  * Execute the console command.
    //  *
    //  * @return void
    //  */
    // public function handle()
    // {
    //     // It's possible for the developer to specify the tables to modify in this
    //     // schema operation. The developer may also specify if this table needs
    //     // to be freshly created so we can create the appropriate migrations.
    //     $name = Str::snake(trim($this->input->getArgument('name')));

    //     $table = $this->input->getOption('table');

    //     $create = $this->input->getOption('create') ?: false;

    //     // If no table was given as an option but a create option is given then we
    //     // will use the "create" option as the table name. This allows the devs
    //     // to pass a table name into this option as a short-cut for creating.
    //     if (! $table && is_string($create)) {
    //         $table = $create;

    //         $create = true;
    //     }

    //     // Next, we will attempt to guess the table name if this the migration has
    //     // "create" in the name. This will allow us to provide a convenient way
    //     // of creating migrations that create new tables for the application.
    //     if (! $table) {
    //         [$table, $create] = TableGuesser::guess($name);
    //     }

    //     // Now we are ready to write the migration out to disk. Once we've written
    //     // the migration out, we will dump-autoload for the entire framework to
    //     // make sure that the migrations are registered by the class loaders.
    //     $this->writeMigration($name, $table, $create);
    // }

    // /**
    //  * Write the migration file to disk.
    //  *
    //  * @param  string  $name
    //  * @param  string  $table
    //  * @param  bool  $create
    //  * @return void
    //  */
    // protected function writeMigration($name, $table, $create)
    // {
    //     $file = $this->creator->create(
    //         $name,
    //         $this->getMigrationPath(),
    //         $table,
    //         $create
    //     );

    //     $this->components->info(sprintf('Migration [%s] created successfully.', $file));
    // }

    // /**
    //  * Get migration path (either specified by '--path' option or default location).
    //  *
    //  * @return string
    //  */
    // protected function getMigrationPath()
    // {
    //     if (! is_null($targetPath = $this->input->getOption('path'))) {
    //         return ! $this->usingRealPath()
    //                         ? $this->laravel->basePath().'/'.$targetPath
    //                         : $targetPath;
    //     }

    //     return parent::getMigrationPath();
    // }

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
