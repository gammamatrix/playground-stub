<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Model\MakeSkeleton
 */
trait MakeSkeleton
{
    /**
     * @var array<string, mixed>
     */
    protected array $analyze = [];

    protected function buildClass_skeleton(): void
    {
        $create = $this->c->create() ?? $this->c->addCreate();

        $name = $this->c->name();
        $type = $this->c->type();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$create' => $create,
        //     '$name' => $name,
        //     '$type' => $type,
        //     '$this->c->toArray()' => $this->c->toArray(),
        // ]);

        if (empty($create)
            || ! is_array($create)
        ) {
            $this->buildClass_model_create($name, $type);
            // $this->components->error(sprintf('The configuration requires a create section for [--file %s]', $this->option('file')));
            // return;
        }

        $this->analyze = [
            'attributes' => [],
            'casts' => [],
            'fillable' => [],
            'filters' => [
                'ids' => [],
                'dates' => [],
                'flags' => [],
                'trash' => [],
                'columns' => [],
                'json' => [],
            ],
            'sortable' => [],
            'scopes' => [],
        ];

        $this->components->info(sprintf('Building the model skeleton configuration for [%s]', $name));

        // $this->buildClass_skeleton_ids(
        //     $create->primary() ?? null,
        //     $create->ids() ?? []
        // );

        // $this->buildClass_skeleton_timestamps($create->timestamps());

        // $this->buildClass_skeleton_softDeletes($create->softDeletes());

        // if ($create->dates()) {
        //     $this->buildClass_skeleton_dates($create->dates());
        // }

        // if ($create->permissions()) {
        //     $this->buildClass_skeleton_permissions($create->permissions());
        // }

        // if ($create->status()) {
        //     $this->buildClass_skeleton_status($create->status());
        // }

        // if ($create->flags()) {
        //     $this->buildClass_skeleton_flags($create->flags());
        // }

        // if ($create->columns()) {
        //     $this->buildClass_skeleton_columns($create->columns());
        // }

        // if ($create->ui()) {
        //     $this->buildClass_skeleton_ui($create->ui());
        // }

        // if ($create->json()) {
        //     $this->buildClass_skeleton_json($create->json());
        // }
    }

    // protected function buildClass_skeleton_add_cast(string $attribute, array $meta = []): void
    // {
    //     if (empty($attribute) && in_array($attribute, $this->analyze['casts'])) {
    //         $this->components->info(sprintf('Invalid casts column [%s] for [%s]', $attribute, $this->configuration['name']));

    //         return;
    //     }

    //     $type = empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'];

    //     if (in_array($type, [
    //         'uuid',
    //         'mediumText',
    //         'largeText',
    //     ])) {
    //         $type = 'string';
    //     } elseif (in_array($type, [
    //         'integer',
    //         'tinyInteger',
    //         'smallInteger',
    //         'mediumInteger',
    //         'bigInteger',
    //     ])) {
    //         $type = 'integer';
    //     } elseif (in_array($type, [
    //         'float',
    //     ])) {
    //         $type = 'float';
    //     } elseif (in_array($type, [
    //         'double',
    //     ])) {
    //         $type = 'double';
    //     } elseif (in_array($type, [
    //         'decimal',
    //     ])) {
    //         $type = 'decimal';
    //     } elseif (in_array($type, [
    //         'JSON_ARRAY',
    //         'JSON_OBJECT',
    //     ])) {
    //         $type = 'array';
    //     }

    //     // Add to casts
    //     $this->configuration['casts'][$attribute] = $type;

    //     $this->analyze['casts'][] = $attribute;
    // }

    // protected function buildClass_skeleton_add_attribute(string $attribute, array $meta = []): void
    // {
    //     if (empty($attribute) && in_array($attribute, $this->analyze['attributes'])) {
    //         $this->components->info(sprintf('Invalid attributes column [%s] for [%s]', $attribute, $this->configuration['name']));

    //         return;
    //     }

    //     $type = empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'];

    //     $hasDefault = array_key_exists('default', $meta);

    //     $value = $hasDefault ? $meta['default'] : null;

    //     if (! $hasDefault) {
    //         if (in_array($type, [
    //             'uuid',
    //             'mediumText',
    //             'largeText',
    //         ])) {
    //             $value = null;
    //         } elseif (in_array($type, [
    //             'tinyInteger',
    //             'mediumInteger',
    //             'bigInteger',
    //         ])) {
    //             $value = 0;
    //         } elseif (in_array($type, [
    //             'JSON_ARRAY',
    //         ])) {
    //             $value = '[]';
    //         } elseif (in_array($type, [
    //             'JSON_OBJECT',
    //         ])) {
    //             $value = '{}';
    //         }
    //     }

    //     // Add to casts
    //     $this->configuration['attributes'][$attribute] = $value;

    //     $this->analyze['attributes'][] = $attribute;
    // }

    // protected function buildClass_skeleton_add_fillable(string $attribute): void
    // {
    //     if (empty($attribute) && in_array($attribute, $this->analyze['fillable'])) {
    //         $this->components->info(sprintf('Invalid fillable column [%s] for [%s]', $attribute, $this->configuration['name']));

    //         return;
    //     }

    //     // Add to fillable
    //     $this->configuration['fillable'][] = $attribute;

    //     $this->analyze['fillable'][] = $attribute;
    // }

    // protected function buildClass_skeleton_add_sort(string $attribute, array $meta = []): void
    // {
    //     if (empty($attribute) && in_array($attribute, $this->analyze['sortable'])) {
    //         $this->components->info(sprintf('Invalid sortable column [%s] for [%s]', $attribute, $this->configuration['name']));

    //         return;
    //     }

    //     // Add to sortable
    //     $this->configuration['sortable'][] = [
    //         'column' => $attribute,
    //         'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //         'nullable' => ! empty($meta['nullable']),
    //     ];

    //     $this->analyze['sortable'][] = $attribute;
    // }

    // protected function buildClass_skeleton_ids(
    //     mixed $primary,
    //     array $ids
    // ): void {

    //     // Make sure IDs exists in filters.
    //     if (! empty($this->configuration['filters']['ids'])) {
    //         $this->analyze['filters']['ids'] = $this->configuration['filters']['ids'];
    //     }

    //     $this->configuration['filters']['ids'] = [];

    //     $this->components->info(sprintf('Adding ids to [%s]', $this->configuration['name']));

    //     $added = [];

    //     if (is_string($primary) && in_array(strtolower($primary), [
    //         'uuid',
    //         'string',
    //         'integer',
    //         'bigInteger',
    //         'increments',
    //     ])) {
    //         $type = 'string';
    //         if ($primary === 'uuid') {
    //             $type = 'uuid';
    //         } elseif (in_array($primary, [
    //             'integer',
    //             'bigInteger',
    //             'increments',
    //         ])) {
    //             $type = 'integer';
    //         }

    //         $attribute = 'id';
    //         // Add to filters
    //         $this->configuration['filters']['ids'][] = [
    //             'column' => $attribute,
    //             'type' => $type,
    //             'nullable' => false,
    //         ];
    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, [
    //             'column' => $attribute,
    //             'type' => $type,
    //             'nullable' => false,
    //         ]);
    //     } else {
    //         $this->components->error(sprintf(
    //             'Unexpected primary option for buildClass_skeleton_ids(%1%s, $ids) the skeleton configuration for [%s]',
    //             $this->configuration['name']
    //         ));
    //     }

    //     foreach ($ids as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to IDs in [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters
    //         $this->configuration['filters']['ids'][] = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //         ];
    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         $this->buildClass_skeleton_add_attribute($attribute, $meta);

    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //     }
    // }

    // protected function buildClass_skeleton_timestamps($hasTimestamps): void
    // {
    //     if (! $hasTimestamps) {
    //         return;
    //     }

    //     $this->components->info(sprintf('Adding timestamps to [%s]', $this->configuration['name']));

    //     $attribute = 'created_at';

    //     // Add to filters
    //     $this->configuration['filters']['dates'][] = [
    //         'column' => $attribute,
    //         'type' => 'timestamp',
    //         'nullable' => true,
    //     ];
    //     $this->buildClass_skeleton_add_sort($attribute, [
    //         'type' => 'string',
    //         'nullable' => true,
    //     ]);
    //     $this->buildClass_skeleton_add_cast($attribute, [
    //         'type' => 'timestamp',
    //     ]);

    //     $attribute = 'updated_at';

    //     // Add to filters
    //     $this->configuration['filters']['dates'][] = [
    //         'column' => $attribute,
    //         'type' => 'timestamp',
    //         'nullable' => true,
    //     ];
    //     $this->buildClass_skeleton_add_sort($attribute, [
    //         'type' => 'string',
    //         'nullable' => true,
    //     ]);
    //     $this->buildClass_skeleton_add_cast($attribute, [
    //         'type' => 'timestamp',
    //     ]);
    // }

    // protected function buildClass_skeleton_softDeletes($hasSoftDeletes): void
    // {
    //     if (! $hasSoftDeletes) {
    //         if (empty($this->configuration['filters']['trash'])) {
    //             unset($this->configuration['filters']['trash']);
    //             $this->components->info(sprintf('Removing soft deletes from filters on [%s]', $this->configuration['name']));
    //         }

    //         return;
    //     }

    //     $attribute = 'deleted_at';

    //     // Add to filters
    //     $this->configuration['filters']['dates'][] = [
    //         'column' => $attribute,
    //         'type' => 'timestamp',
    //         'nullable' => true,
    //     ];
    //     $this->buildClass_skeleton_add_sort($attribute, [
    //         'column' => $attribute,
    //         'type' => 'string',
    //         'nullable' => true,
    //     ]);
    //     $this->buildClass_skeleton_add_cast($attribute, [
    //         'type' => 'timestamp',
    //     ]);

    //     $this->configuration['filters']['trash'] = [
    //         'hide' => true,
    //         'only' => true,
    //         'with' => true,
    //     ];
    // }

    // protected function buildClass_skeleton_dates(array $dates): void
    // {
    //     $this->components->info(sprintf('Adding dates to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($dates as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to dates for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters
    //         $this->configuration['filters']['dates'][] = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'datetime' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //         ];
    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'datetime' : $meta['type'],
    //         ]);
    //     }
    // }

    // protected function buildClass_skeleton_permissions(array $permissions): void
    // {
    //     // Make sure permissions exists in filters.
    //     if (! empty($this->configuration['filters']['permissions'])) {
    //         $this->analyze['filters']['permissions'] = $this->configuration['filters']['permissions'];
    //     }

    //     $this->configuration['filters']['permissions'] = [];

    //     $this->components->info(sprintf('Adding permissions to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($permissions as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to permissions for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters

    //         $options = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //             'unsigned' => ! empty($meta['unsigned']),
    //         ];

    //         if (! empty($meta['icon']) && is_string($meta['icon'])) {
    //             $options['icon'] = $meta['icon'];

    //             $options['label'] = empty($meta['label']) || ! is_string($meta['label'])
    //                 ? Str::of($attribute)->replace('_', ' ')->title()->toString()
    //                 : $meta['label'];
    //         }

    //         $this->configuration['filters']['permissions'][] = $options;
    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //         ]);
    //     }
    // }

    // protected function buildClass_skeleton_status(array $status): void
    // {
    //     // Make sure status exists in filters.
    //     if (! empty($this->configuration['filters']['status'])) {
    //         $this->analyze['filters']['status'] = $this->configuration['filters']['status'];
    //     }

    //     $this->configuration['filters']['status'] = [];

    //     $this->components->info(sprintf('Adding status to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($status as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to status for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters

    //         $options = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //             'unsigned' => ! empty($meta['unsigned']),
    //         ];

    //         if (! empty($meta['icon']) && is_string($meta['icon'])) {
    //             $options['icon'] = $meta['icon'];

    //             $options['label'] = empty($meta['label']) || ! is_string($meta['label'])
    //                 ? Str::of($attribute)->replace('_', ' ')->title()->toString()
    //                 : $meta['label'];
    //         }

    //         $this->configuration['filters']['status'][] = $options;
    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //         ]);
    //     }
    // }

    // protected function buildClass_skeleton_flags(array $flags): void
    // {
    //     // Make sure flags exists in filters.
    //     if (! empty($this->configuration['filters']['flags'])) {
    //         $this->analyze['filters']['flags'] = $this->configuration['filters']['flags'];
    //     }

    //     $this->configuration['filters']['flags'] = [];

    //     $this->components->info(sprintf('Adding flags to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($flags as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to flags for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters

    //         $options = [
    //             'column' => $attribute,
    //             'label' => empty($meta['label']) || ! is_string($meta['label']) ? '' : $meta['label'],
    //             'icon' => empty($meta['icon']) || ! is_string($meta['icon']) ? '' : $meta['icon'],
    //         ];

    //         if (empty($options['label'])) {
    //             $options['label'] = Str::of($attribute)->replace('_', ' ')->title()->toString();
    //         }

    //         $this->configuration['filters']['flags'][] = $options;

    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => 'boolean',
    //         ]);
    //         $this->buildClass_skeleton_add_attribute($attribute, $meta);
    //     }
    // }

    // protected function buildClass_skeleton_columns(array $columns): void
    // {
    //     // Make sure columns exists in filters.
    //     if (! empty($this->configuration['filters']['columns'])) {
    //         $this->analyze['filters']['columns'] = $this->configuration['filters']['columns'];
    //     }

    //     $this->configuration['filters']['columns'] = [];

    //     $this->components->info(sprintf('Adding columns to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($columns as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to columns for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters
    //         $this->configuration['filters']['columns'][] = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //         ];
    //         $added[] = $attribute;
    //         $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //         ]);
    //         $this->buildClass_skeleton_add_attribute($attribute, $meta);
    //     }
    // }

    // protected function buildClass_skeleton_json(array $json): void
    // {
    //     // Make sure json exists in filters.
    //     if (! empty($this->configuration['filters']['json'])) {
    //         $this->analyze['filters']['json'] = $this->configuration['filters']['json'];
    //     }

    //     $this->configuration['filters']['json'] = [];

    //     $this->components->info(sprintf('Adding json to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($json as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to json for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters
    //         $this->configuration['filters']['json'][] = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'JSON' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //         ];
    //         $added[] = $attribute;
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => 'array',
    //         ]);
    //         $this->buildClass_skeleton_add_attribute($attribute, $meta);
    //     }
    // }

    // protected function buildClass_skeleton_ui(array $ui): void
    // {
    //     // Make sure ui exists in filters.
    //     if (! empty($this->configuration['filters']['ui'])) {
    //         $this->analyze['filters']['ui'] = $this->configuration['filters']['ui'];
    //     }

    //     $this->configuration['filters']['ui'] = [];

    //     $this->components->info(sprintf('Adding ui to [%s]', $this->configuration['name']));
    //     $added = [];

    //     foreach ($ui as $attribute => $meta) {
    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     '$attribute' => $attribute,
    //         //     '$meta' => $meta,
    //         // ]);
    //         if (in_array($attribute, $added)) {
    //             $this->components->error(sprintf(
    //                 'Column [%s] already added to ui for [%s]',
    //                 $attribute,
    //                 $this->configuration['name']
    //             ));

    //             continue;
    //         }

    //         // Add to filters
    //         $this->configuration['filters']['ui'][] = [
    //             'column' => $attribute,
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //             'nullable' => ! empty($meta['nullable']),
    //         ];
    //         $added[] = $attribute;

    //         if ($attribute !== 'ui') {
    //             $this->buildClass_skeleton_add_sort($attribute, $meta);
    //         }
    //         if (empty($meta['readOnly'])) {
    //             $this->buildClass_skeleton_add_fillable($attribute);
    //         }
    //         $this->buildClass_skeleton_add_cast($attribute, [
    //             'type' => empty($meta['type']) || ! is_string($meta['type']) ? 'string' : $meta['type'],
    //         ]);
    //         $this->buildClass_skeleton_add_attribute($attribute, $meta);
    //     }
    // }
}
