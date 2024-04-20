<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Request;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Building\Request\BuildRequest
 */
trait BuildRequest
{
    protected function buildClass_form(string $name): void
    {
        $model = $this->model;

        if (in_array($this->configurationType, [
            'update',
            'store',
        ])) {
            $this->buildClass_slug_table();
        }

        $fillable = $model?->fillable();
        if (! empty($fillable)) {
            $this->buildClass_rules_constant($model);
        }

        // Types: store

        if (in_array($this->configurationType, [
            'abstract-store',
        ])) {
            $this->c->setOptions([
                'store' => ! empty($this->option('with-store')),
            ]);
            $this->createStoreTraits();
        }

        // $traits = [];

        // // $this->createPaginationTrait('StoreSlugTrait', 'request/trait.store.slug.stub');
        // $this->createTrait(
        //     $this->folder(),
        //     'StoreSlugTrait',
        //     'request/trait.store.slug.stub'
        // );

        // $traits['StoreSlugTrait'] = '';
        // $traits['StoreSlugTrait'] = sprintf(
        //     '%1$s\%2$s',
        //     // $this->parseClassInput($this->configuration['namespace']),
        //     $this->getDefaultNamespace(
        //         $this->parseClassInput($this->configuration['namespace'])
        //     ),
        //     'StoreSlugTrait'
        // );

        // foreach ($traits as $trait => $class) {
        //     $this->configuration['uses'][$trait] = $class;
        // }

    }

    protected function buildClass_rules_constant(
        Model $model
    ): void {

        $indent = 4;

        $rules = '';

        $hasFillable = false;

        if (in_array($this->configurationType, [
            'create',
            'edit',
            'update',
            'store',
        ])) {

            $rules = $this->buildClass_rules_constant_for_only_fillable(
                $model,
                $indent * 2
            );
            $hasFillable = ! empty(trim($rules));
        }

        $rules .= $this->buildClass_rules_constant_for_return_url($indent);
        if (! $hasFillable && ! empty($rules)) {
            $rules = PHP_EOL.$rules;
        }

        if (empty(trim($rules))) {
            return;
        }

        $rules .= str_repeat(' ', $indent);

        if (! empty($this->searches['constants'])) {
            $this->searches['constants'] .= PHP_EOL;
        }

        $this->searches['constants'] .= sprintf(
            '    /**
     * @var array RULES The validation rules.
     */
    const RULES = [%1$s];',
            $rules
        );

        $this->searches['constants'] .= PHP_EOL;
    }

    protected function buildClass_rules_constant_for_return_url(
        int $indent = 4
    ): string {

        if (! in_array($this->configurationType, [
            'create',
            'edit',
            'destroy',
            'lock',
            'restore',
            'store',
            'unlock',
            'update',
        ])) {
            return '';
        }

        $rules = str_repeat(' ', $indent * 2);

        $rules .= '\'_return_url\' => [\'nullable\', \'url\'],';

        $rules .= PHP_EOL;

        return $rules;
    }

    protected function buildClass_rules_constant_for_only_fillable(
        Model $model,
        int $indent = 8
    ): string {

        $rules = PHP_EOL;

        $casts = $model->casts();

        foreach ($model->fillable() as $i => $column) {

            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$i' => $i,
            //     '$column' => $column,
            // ]);
            if (empty($column) || ! is_string($column)) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for rules',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $rule = '';

            $column_meta = $this->buildClass_model_meta($column, $model);

            $cast = array_key_exists($column, $casts)
                && is_string($casts[$column])
                ? $casts[$column]
                : null;

            if (is_null($cast)) {
                $ids = $model->create()?->ids();
                if (! empty($ids[$column])) {
                    if (! empty($ids[$column]->type())) {
                        $cast = $ids[$column]->type();
                    }
                }
            }

            if (! Str::of($rule)->contains('nullable')
                && ! empty($column_meta['nullable'])
            ) {
                $rule .= "'nullable'";
            }

            if ($cast === 'datetime') {
                // $cast = 'date';
                // Allows parsing: tomorrow midnight
                $cast = 'string';
            }

            if ($cast) {
                if (! empty($rule)) {
                    $rule .= ', ';
                }
                $rule .= sprintf('\'%1$s\'', $cast);
            }

            $rules .= str_repeat(' ', $indent);

            $rules .= sprintf(
                '\'%1$s\' => [%2$s],',
                $column,
                $rule
            );

            $rules .= PHP_EOL;
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$rules' => $rules,
        // ]);

        return $rules;
    }

    public function buildClass_slug_table(): void
    {
        if (in_array($this->searches['extends'], [
            'AbstractStoreRequest',
            'AbstractUpdateRequest',
        ])) {
            if (! empty($this->searches['properties'])) {
                $this->searches['properties'] .= PHP_EOL;
            }
            $this->searches['properties'] .= sprintf(
                '%2$s    protected string $slug_table = \'%1$s\';',
                $this->model['table'] ?? '',
                PHP_EOL
            );
        }
    }

    protected function buildClass_index(string $name): void
    {
        $modelConfiguration = $this->getModelConfiguration();

        $ids = false;
        $flags = false;
        $model = false;
        $dates = false;

        $slug = false;

        $traits = [];

        if (in_array($this->configurationType, [
            'index',
        ])) {
            if ($this->option('skeleton')) {

                $this->c->setOptions([
                    'extends_use' => sprintf(
                        '%1$s\Http\Requests\AbstractIndexRequest',
                        $this->c->namespace()
                    ),
                ]);
                $this->c->setOptions([
                    'extends' => 'AbstractIndexRequest',
                ]);

                $this->searches['extends_use'] = $this->parseClassInput($this->c->extends_use());
                $this->searches['extends'] = $this->parseClassInput($this->c->extends());

                $this->buildClass_index_dates();
                $this->buildClass_index_flags();
                $this->buildClass_index_ids();
                $this->buildClass_index_columns();
                $this->buildClass_index_sortable();
            }
        }

        // Types: index

        if (in_array($this->configurationType, [
            'abstract-index',
        ])) {
            $dates = true;
            $flags = true;
            $model = true;
            $ids = true;

            if ($this->option('with-pagination')) {
                $this->c->setOptions([
                    'pagination' => true,
                ]);
                $this->createPaginationTraits();
            }

        }

    }

    protected function createPaginationTraits(): void
    {
        $format_sql = config('playground-stub.format.sql');
        if (is_string($format_sql) && $format_sql) {
            $this->searches['format_sql'] = $format_sql;
        }

        $traits = [
            'PaginationDatesTrait' => 'request/trait.pagination.dates.stub',
            'PaginationFlagsTrait' => 'request/trait.pagination.flags.stub',
            'PaginationIdsTrait' => 'request/trait.pagination.ids.stub',
            'PaginationModelTrait' => 'request/trait.pagination.model.stub',
            'PaginationSortableTrait' => 'request/trait.pagination.sortable.stub',
        ];

        foreach ($traits as $class => $template) {
            // $this->createPaginationTrait($class, $template);
            $this->createTrait(
                $this->folder(),
                $class,
                $template
            );
            $this->buildClass_uses_add('', $class);
            // $this->configuration['uses'][$class] = '';
            // $this->configuration['uses'][$class] = $this->getDefaultNamespace(
            //     $this->parseClassInput($this->configuration['namespace'])
            // );
        }
    }

    protected function createStoreTraits(): void
    {
        $format_sql = config('playground-stub.format.sql');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$format_sql' => $format_sql,
        // ]);
        if (is_string($format_sql) && $format_sql) {
            $this->searches['format_sql'] = $format_sql;
        }

        $traits = [
            'StoreContentTrait' => 'request/trait.store.content.stub',
            'StoreSlugTrait' => 'request/trait.store.slug.stub',
            'StoreFilterTrait' => 'request/trait.store.filter.stub',
        ];

        foreach ($traits as $class => $template) {
            $this->createTrait(
                $this->folder(),
                $class,
                $template
            );
            $this->buildClass_uses_add('', $class);
            // $this->configuration['uses'][$class] = '';
            // $this->configuration['uses'][$class] = $this->getDefaultNamespace(
            //     $this->parseClassInput($this->configuration['namespace'])
            // );
        }
    }

    protected function createPaginationTrait(string $class, string $template): void
    {
        $path = $this->resolveStubPath($template);

        $stub = $this->files->get($path);

        $this->search_and_replace($stub);

        $file = sprintf('%1$s.php', $class);

        $destination = sprintf(
            '%1$s/%2$s',
            $this->folder(),
            $file
        );

        $full_path = $this->laravel->storagePath().$destination;
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder()' => $this->folder(),
        //     '$destination' => $destination,
        //     '$full_path' => $full_path,
        // ]);

        $this->files->put($full_path, $stub);

        $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    }

    protected function buildClass_index_dates(): void
    {
        if (empty($this->model['filters'])
            || ! is_array($this->model['filters'])
            || empty($this->model['filters']['dates'])
            || ! is_array($this->model['filters']['dates'])
        ) {
            return;
        }

        $dates = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($this->model['filters']['dates'] as $i => $date) {

            if (empty($date['column']) || ! is_string($date['column'])) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for date',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $dates .= str_repeat(' ', 8);

            $date['label'] = empty($date['label'])
                || ! is_string($date['label'])
                ? Str::of($date['column'])->replace('_', ' ')->title()
                : $date['label'];

            $dates .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'nullable\' => %3$s],',
                $date['column'],
                $date['label'],
                empty($date['nullable']) ? 'false' : 'true'
            );

            $dates .= PHP_EOL;
        }

        $dates .= str_repeat(' ', 4);

        $this->searches['properties'] .= sprintf(
            '    protected array $paginationDates = [%1$s];',
            $dates
        );

        $this->searches['properties'] .= PHP_EOL;

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_flags(): void
    {
        if (empty($this->model['filters'])
            || ! is_array($this->model['filters'])
            || empty($this->model['filters']['flags'])
            || ! is_array($this->model['filters']['flags'])
        ) {
            return;
        }

        $flags = PHP_EOL;

        foreach ($this->model['filters']['flags'] as $i => $flag) {

            if (empty($flag['column']) || ! is_string($flag['column'])) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for flag',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $flags .= str_repeat(' ', 8);

            $flags .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'icon\' => \'%3$s\'],',
                $flag['column'],
                $flag['label'],
                empty($flag['icon']) ? '' : $flag['icon'],
                // Str::of($flag)->replace('_', ' ')->title()
            );

            $flags .= PHP_EOL;
        }

        $flags .= str_repeat(' ', 4);

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        $this->searches['properties'] .= sprintf(
            '    protected array $paginationFlags = [%1$s];',
            $flags
        );

        $this->searches['properties'] .= PHP_EOL;

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_ids(): void
    {
        if (empty($this->model['filters'])
            || ! is_array($this->model['filters'])
            || empty($this->model['filters']['ids'])
            || ! is_array($this->model['filters']['ids'])
        ) {
            return;
        }

        $ids = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($this->model['filters']['ids'] as $i => $id) {

            if (empty($id['column']) || ! is_string($id['column'])) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for id',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $ids .= str_repeat(' ', 8);

            $id['label'] = empty($id['label'])
                || ! is_string($id['label'])
                ? Str::of($id['column'])->replace('_', ' ')->title()
                : $id['label'];

            $ids .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'type\' => \'%3$s\', \'nullable\' => %4$s],',
                $id['column'],
                $id['label'],
                empty($id['type']) || ! is_string($id['type']) ? 'string' : $id['type'],
                empty($id['nullable']) ? 'false' : 'true'
            );

            $ids .= PHP_EOL;
        }

        $ids .= str_repeat(' ', 4);

        $this->searches['properties'] .= sprintf(
            '    protected array $paginationIds = [%1$s];',
            $ids
        );

        $this->searches['properties'] .= PHP_EOL;

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_columns(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     '$this->model' => $this->model,
        // ]);
        if (empty($this->model['filters'])
            || ! is_array($this->model['filters'])
            || empty($this->model['filters']['columns'])
            || ! is_array($this->model['filters']['columns'])
        ) {
            return;
        }

        $model = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($this->model['filters']['columns'] as $i => $meta) {

            if (empty($meta['column']) || ! is_string($meta['column'])) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for date',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $model .= str_repeat(' ', 8);

            $meta['label'] = empty($meta['label'])
                || ! is_string($meta['label'])
                ? Str::of($meta['column'])->replace('_', ' ')->title()
                : $meta['label'];

            $model .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'type\' => \'%3$s\', \'nullable\' => %4$s],',
                $meta['column'],
                $meta['label'],
                empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
                empty($meta['nullable']) ? 'false' : 'true'
            );

            $model .= PHP_EOL;
        }

        $model .= str_repeat(' ', 4);

        $this->searches['properties'] .= sprintf(
            '    protected array $paginationColumns = [%1$s];',
            $model
        );

        $this->searches['properties'] .= PHP_EOL;

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }

    protected function buildClass_index_sortable(): void
    {
        if (empty($this->model['sortable'])
            || ! is_array($this->model['sortable'])
        ) {
            return;
        }

        $sortable = PHP_EOL;

        if (! empty($this->searches['properties'])) {
            $this->searches['properties'] .= PHP_EOL;
        }

        foreach ($this->model['sortable'] as $i => $meta) {

            if (empty($meta['column']) || ! is_string($meta['column'])) {
                \Log::debug(__METHOD__, [
                    'ISSUE' => 'Missing column for date',
                    '$i' => $i,
                    '$this->model' => $this->model,
                ]);

                continue;
            }

            $sortable .= str_repeat(' ', 8);

            $meta['label'] = empty($meta['label'])
                || ! is_string($meta['label'])
                ? Str::of($meta['column'])->replace('_', ' ')->title()
                : $meta['label'];

            $type = empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'];

            if (in_array($type, [
                'tinyText',
                'mediumText',
                'largeText',
                'uuid',
            ])) {
                $type = 'string';
            } elseif (in_array($type, [
                'decimal',
                'float',
                'double',
            ])) {
                $type = 'float';
            } elseif (in_array($type, [
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'integer';
            }

            $sortable .= sprintf(
                '\'%1$s\' => [\'column\' => \'%1$s\', \'label\' => \'%2$s\', \'type\' => \'%3$s\'],',
                $meta['column'],
                $meta['label'],
                $type,
            );

            $sortable .= PHP_EOL;
        }

        $sortable .= str_repeat(' ', 4);

        $this->searches['properties'] .= sprintf(
            '    protected array $sortable = [%1$s];',
            $sortable
        );

        $this->searches['properties'] .= PHP_EOL;

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     // '$this->model' => $this->model,
        // ]);
    }
}
