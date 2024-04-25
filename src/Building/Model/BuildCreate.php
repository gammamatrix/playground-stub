<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\BuildModel
 */
trait BuildCreate
{
    // protected array $analyze = [];

    protected function buildClass_model_create(string $name, string $type): Create
    {
        if (empty($name) || empty($type)) {
            throw new \Exception(sprintf(
                'ModelSkeletonCreateMakeTrait::buildClass_model_create(string $name {%1$s}, string $type {%2$s}) - expecting a valid name and type.',
                $name,
                $type
            ));
        }

        $create = $this->c->create() ?? $this->c->addCreate();

        // $this->configuration['create'] = [
        //     'class' => '',
        //     'primary' => '',
        //     'ids' => [],
        //     'unique' => [],
        //     'timestamps' => false,
        //     'softDeletes' => false,
        //     'dates' => [],
        //     'permissions' => [],
        //     'status' => [],
        //     'flags' => [],
        //     'columns' => [],
        //     'ui' => [],
        //     'json' => [],
        // ];

        // $this->buildClass_model_table(
        //     $name,
        //     $type,
        //     $this->c->module_slug()
        // );

        // $this->buildClass_model_unique(
        //     $name,
        //     $type
        // );

        // // $config = config('playground-stub');
        // // $config_columns = config('playground-stub.columns');

        // $this->buildClass_model_create_ids($name, $type);
        // $this->buildClass_model_create_dates($name, $type);
        // $this->buildClass_model_create_permissions($name, $type);
        // $this->buildClass_model_create_status($name, $type);
        // $this->buildClass_model_create_flags($name, $type);
        // $this->buildClass_model_create_columns($name, $type);
        // $this->buildClass_model_create_ui($name, $type);
        // $this->buildClass_model_create_json($name, $type);
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$config' => $config,
        //     // '$config_columns' => $config_columns,
        //     '$type' => $type,
        //     '$this->c' => $this->c,
        //     // '$this->options()' => $this->options(),
        // ]);
        return $create;
    }

    // protected function buildClass_model_unique(
    //     string $name,
    //     string $type
    // ): void {
    //     $config_columns_unique = config('playground-stub.columns.unique');

    //     $unique_slug = [
    //         'keys' => [],
    //     ];

    //     $slug_key = '';

    //     if (in_array($type, [
    //         'resource',
    //         'api',
    //     ])) {
    //         $slug_key = 'slug';
    //     }

    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $slug_key = 'slug-parent';
    //     }

    //     if (! empty($slug_key)
    //         && ! empty($config_columns_unique[$slug_key])
    //         && is_array($config_columns_unique[$slug_key])
    //         && ! empty($config_columns_unique[$slug_key]['keys'])
    //         && is_array($config_columns_unique[$slug_key]['keys'])
    //     ) {

    //         foreach ($config_columns_unique[$slug_key]['keys'] as $i => $column) {
    //             if ($column
    //                 && is_string($column)
    //                 && preg_match('/^[a-z][a-z0-9_]+$/i', $column)
    //                 && ! in_array($column, $unique_slug['keys'])
    //             ) {
    //                 $unique_slug['keys'][] = $column;
    //             }
    //         }
    //     }
    //     // if (! empty($unique_slug['keys'])) {
    //     //     $this->c->create?->['unique'][] = $unique_slug;
    //     // }
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     'test_0' => !empty($unique_slug['keys']),
    //     //     '$config_columns_unique' => $config_columns_unique,
    //     //     '$slug_key' => $slug_key,
    //     // ]);

    // }

    // protected function buildClass_model_create_ids(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $ids = config('playground-stub.columns.ids');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //     ])) {
    //         $this->configuration['create']['primary'] = 'increments';
    //     }

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['primary'] = 'uuid';
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($ids as $column => $meta) {
    //             $this->buildClass_model_create_ids_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {

    //         $column = Str::of($name)->snake()->finish('_type')->toString();

    //         $this->buildClass_model_create_ids_add(
    //             $name,
    //             $type,
    //             $column,
    //             [
    //                 'type' => 'string',
    //                 'nullable' => true,
    //                 'index' => true,
    //             ]
    //         );
    //     }
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$ids' => $ids,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_ids_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         'nullable' => true,
    //         'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'increments',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     if (array_key_exists('foreign', $meta) && is_array($meta['foreign'])) {
    //         $options['foreign'] = [
    //             'references' => empty($meta['foreign']['references']) || ! is_string($meta['foreign']['references']) ? '' : $meta['foreign']['references'],
    //             'on' => null,
    //         ];
    //         if (array_key_exists('on', $meta['foreign'])) {
    //             if (is_null($meta['foreign']['on'])) {
    //                 $options['foreign']['on'] = $this->configuration['table'];
    //             } elseif (is_string($meta['foreign']['on']) && $meta['foreign']['on']) {
    //                 $options['foreign']['on'] = $meta['foreign']['on'];
    //             }
    //         }
    //     }

    //     $this->configuration['create']['ids'][$column] = $options;
    // }

    // protected function buildClass_model_create_dates(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $dates = config('playground-stub.columns.dates');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($dates as $column => $meta) {
    //             $this->buildClass_model_create_dates_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$dates' => $dates,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_dates_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'nullable' => true,
    //         'index' => false,
    //     ];

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $this->configuration['create']['dates'][$column] = $options;
    // }

    // protected function buildClass_model_create_permissions(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $permissions = config('playground-stub.columns.permissions');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($permissions as $column => $meta) {
    //             $this->buildClass_model_create_permissions_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$permissions' => $permissions,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_permissions_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         // 'nullable' => true,
    //         // 'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'tinyInteger',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('default', $meta) && ! is_array($meta['default']) && ! is_object($meta['default'])) {
    //         $options['default'] = $meta['default'];
    //     }

    //     if (array_key_exists('unsigned', $meta) && is_bool($meta['unsigned'])) {
    //         $options['unsigned'] = $meta['unsigned'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $createLabel = false;

    //     if (array_key_exists('label', $meta) && is_string($meta['label'])) {
    //         $options['label'] = $meta['label'];
    //         $createLabel = true;
    //     }

    //     if (array_key_exists('icon', $meta) && is_string($meta['icon'])) {
    //         $options['icon'] = $meta['icon'];
    //         $createLabel = true;
    //     }

    //     if ($createLabel && empty($meta['label'])) {
    //         $meta['label'] = Str::of($column)->replace('_', ' ')->title()->toString();
    //     }

    //     $this->configuration['create']['permissions'][$column] = $options;
    // }

    // protected function buildClass_model_create_status(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $status = config('playground-stub.columns.status');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($status as $column => $meta) {
    //             $this->buildClass_model_create_status_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$status' => $status,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_status_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         // 'nullable' => true,
    //         // 'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'tinyInteger',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('default', $meta) && ! is_array($meta['default']) && ! is_object($meta['default'])) {
    //         $options['default'] = $meta['default'];
    //     }

    //     if (array_key_exists('unsigned', $meta) && is_bool($meta['unsigned'])) {
    //         $options['unsigned'] = $meta['unsigned'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $createLabel = false;

    //     if (array_key_exists('label', $meta) && is_string($meta['label'])) {
    //         $options['label'] = $meta['label'];
    //         $createLabel = true;
    //     }

    //     if (array_key_exists('icon', $meta) && is_string($meta['icon'])) {
    //         $options['icon'] = $meta['icon'];
    //         $createLabel = true;
    //     }

    //     if ($createLabel && empty($meta['label'])) {
    //         $meta['label'] = Str::of($column)->replace('_', ' ')->title()->toString();
    //     }

    //     $this->configuration['create']['status'][$column] = $options;
    // }

    // protected function buildClass_model_create_flags(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $flags = config('playground-stub.columns.flags');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($flags as $column => $meta) {
    //             $this->buildClass_model_create_flags_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$flags' => $flags,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_flags_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         // 'nullable' => true,
    //         // 'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'tinyInteger',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('default', $meta) && ! is_array($meta['default']) && ! is_object($meta['default'])) {
    //         $options['default'] = $meta['default'];
    //     }

    //     if (array_key_exists('unsigned', $meta) && is_bool($meta['unsigned'])) {
    //         $options['unsigned'] = $meta['unsigned'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $createLabel = false;

    //     if (array_key_exists('label', $meta) && is_string($meta['label'])) {
    //         $options['label'] = $meta['label'];
    //         $createLabel = true;
    //     }

    //     if (array_key_exists('icon', $meta) && is_string($meta['icon'])) {
    //         $options['icon'] = $meta['icon'];
    //         $createLabel = true;
    //     }

    //     if ($createLabel && empty($meta['label'])) {
    //         $meta['label'] = Str::of($column)->replace('_', ' ')->title()->toString();
    //     }

    //     $this->configuration['create']['flags'][$column] = $options;
    // }

    // protected function buildClass_model_create_columns(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $columns = config('playground-stub.columns.columns');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($columns as $column => $meta) {
    //             $this->buildClass_model_create_columns_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$columns' => $columns,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_columns_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         // 'nullable' => true,
    //         // 'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'tinyInteger',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('default', $meta) && ! is_array($meta['default']) && ! is_object($meta['default'])) {
    //         $options['default'] = $meta['default'];
    //     }

    //     if (array_key_exists('unsigned', $meta) && is_bool($meta['unsigned'])) {
    //         $options['unsigned'] = $meta['unsigned'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('html', $meta) && is_bool($meta['html'])) {
    //         $options['html'] = $meta['html'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $createLabel = false;

    //     if (array_key_exists('label', $meta) && is_string($meta['label'])) {
    //         $options['label'] = $meta['label'];
    //         $createLabel = true;
    //     }

    //     if (array_key_exists('icon', $meta) && is_string($meta['icon'])) {
    //         $options['icon'] = $meta['icon'];
    //         $createLabel = true;
    //     }

    //     if ($createLabel && empty($meta['label'])) {
    //         $meta['label'] = Str::of($column)->replace('_', ' ')->title()->toString();
    //     }

    //     $this->configuration['create']['columns'][$column] = $options;
    // }

    // protected function buildClass_model_create_ui(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $ui = config('playground-stub.columns.ui');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($ui as $column => $meta) {
    //             $this->buildClass_model_create_ui_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$ui' => $ui,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_ui_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         // 'nullable' => true,
    //         // 'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'tinyInteger',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('default', $meta) && ! is_array($meta['default']) && ! is_object($meta['default'])) {
    //         $options['default'] = $meta['default'];
    //     }

    //     if (array_key_exists('unsigned', $meta) && is_bool($meta['unsigned'])) {
    //         $options['unsigned'] = $meta['unsigned'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $createLabel = false;

    //     if (array_key_exists('label', $meta) && is_string($meta['label'])) {
    //         $options['label'] = $meta['label'];
    //         $createLabel = true;
    //     }

    //     if (array_key_exists('icon', $meta) && is_string($meta['icon'])) {
    //         $options['icon'] = $meta['icon'];
    //         $createLabel = true;
    //     }

    //     if ($createLabel && empty($meta['label'])) {
    //         $meta['label'] = Str::of($column)->replace('_', ' ')->title()->toString();
    //     }

    //     $this->configuration['create']['ui'][$column] = $options;
    // }

    // protected function buildClass_model_create_json(string $name, string $type): void
    // {
    //     $config = config('playground-stub');
    //     $json = config('playground-stub.columns.json');

    //     // Add primary key

    //     if (in_array($type, [
    //         'model',
    //         'resource',
    //         'api',
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         $this->configuration['create']['softDeletes'] = true;
    //         $this->configuration['create']['timestamps'] = true;
    //     }

    //     // Add type
    //     if (in_array($type, [
    //         'playground-resource',
    //         'playground-api',
    //     ])) {
    //         foreach ($json as $column => $meta) {
    //             $this->buildClass_model_create_json_add($name, $type, $column, $meta);
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$config' => $config,
    //     //     '$json' => $json,
    //     //     '$type' => $type,
    //     //     '$this->configuration' => $this->configuration,
    //     //     '$this->options()' => $this->options(),
    //     // ]);
    // }

    // protected function buildClass_model_create_json_add(
    //     string $name,
    //     string $type,
    //     string $column,
    //     array $meta,
    // ): void {

    //     $options = [
    //         'type' => 'string',
    //         // 'nullable' => true,
    //         // 'index' => false,
    //     ];

    //     if (! empty($meta['type']) && is_string($meta['type'])) {
    //         if (in_array($meta['type'], [
    //             'tinyInteger',
    //         ])) {
    //             $options['type'] = $meta['type'];
    //         } else {
    //             $options['type'] = $meta['type'];
    //         }
    //     }

    //     if (array_key_exists('readOnly', $meta) && is_bool($meta['readOnly'])) {
    //         $options['readOnly'] = $meta['readOnly'];
    //     }

    //     if (array_key_exists('default', $meta) && ! is_array($meta['default']) && ! is_object($meta['default'])) {
    //         $options['default'] = $meta['default'];
    //     }

    //     if (array_key_exists('unsigned', $meta) && is_bool($meta['unsigned'])) {
    //         $options['unsigned'] = $meta['unsigned'];
    //     }

    //     if (array_key_exists('nullable', $meta) && is_bool($meta['nullable'])) {
    //         $options['nullable'] = $meta['nullable'];
    //     }

    //     if (array_key_exists('index', $meta) && is_bool($meta['index'])) {
    //         $options['index'] = $meta['index'];
    //     }

    //     $createLabel = false;

    //     if (array_key_exists('label', $meta) && is_string($meta['label'])) {
    //         $options['label'] = $meta['label'];
    //         $createLabel = true;
    //     }

    //     if (array_key_exists('icon', $meta) && is_string($meta['icon'])) {
    //         $options['icon'] = $meta['icon'];
    //         $createLabel = true;
    //     }

    //     if ($createLabel && empty($meta['label'])) {
    //         $meta['label'] = Str::of($column)->replace('_', ' ')->title()->toString();
    //     }

    //     $this->configuration['create']['json'][$column] = $options;
    // }
}
