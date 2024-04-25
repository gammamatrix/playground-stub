<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Illuminate\Support\Facades\Log;
use Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Model\Create
 */
class Create extends ModelConfiguration implements Configuration\Contracts\WithSkeleton
{
    use Configuration\Concerns\WithSkeleton;

    protected string $migration = '';

    protected string $primary = '';

    /**
     * @var array<string, CreateId>
     */
    protected array $ids = [];

    /**
     * @var array<int, CreateUnique>
     */
    protected array $unique = [];

    protected bool $timestamps = false;

    protected bool $softDeletes = false;

    /**
     * @var array<string, bool>
     */
    protected array $trash = [
        'hide' => false,
        'only' => false,
        'with' => false,
    ];

    /**
     * @var array<string, CreateDate>
     */
    protected array $dates = [];

    /**
     * @var array<string, CreateFlag>
     */
    protected array $flags = [];

    /**
     * @var array<string, CreateColumn>
     */
    protected array $columns = [];

    /**
     * @var array<string, CreatePermission>
     */
    protected array $permissions = [];

    /**
     * @var array<string, CreateStatus>
     */
    protected array $status = [];

    /**
     * @var array<string, CreateMatrix>
     */
    protected array $matrix = [];

    /**
     * @var array<string, CreateUi>
     */
    protected array $ui = [];

    /**
     * @var array<string, CreateJson>
     */
    protected array $json = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'migration' => '',
        'primary' => '',
        'timestamps' => false,
        'softDeletes' => false,
        'trash' => [],
        'ids' => [],
        'unique' => [],
        'dates' => [],
        'flags' => [],
        'columns' => [],
        'permissions' => [],
        'status' => [],
        'matrix' => [],
        'ui' => [],
        'json' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['migration'])
            && is_string($options['migration'])
        ) {
            $this->migration = $options['migration'];
        }

        if (! empty($options['primary'])
            && is_string($options['primary'])
        ) {
            $allowed_primary = [
                'string',
                'uuid',
                'increments',
            ];
            if (! in_array($options['primary'], $allowed_primary)) {
                Log::warning(__('playground-stub::stub.Model.Create.primary.unexpected', [
                    'primary' => $options['primary'],
                    'allowed' => implode(', ', $allowed_primary),
                ]));
            }
            $this->primary = $options['primary'];
        }

        if (array_key_exists('timestamps', $options)) {
            $this->timestamps = ! empty($options['timestamps']);
        }

        if (array_key_exists('softDeletes', $options)) {
            $this->softDeletes = ! empty($options['softDeletes']);
        }

        if (! empty($options['trash'])
            && is_array($options['trash'])
        ) {
            if (array_key_exists('hide', $options['trash'])) {
                $this->trash['hide'] = ! empty($options['trash']['hide']);
            }

            if (array_key_exists('only', $options['trash'])) {
                $this->trash['only'] = ! empty($options['trash']['only']);
            }

            if (array_key_exists('with', $options['trash'])) {
                $this->trash['with'] = ! empty($options['trash']['with']);
            }
        }

        if (! empty($options['ids'])
            && is_array($options['ids'])
        ) {
            foreach ($options['ids'] as $column => $meta) {
                $this->addId($column, $meta);
            }
        }

        if (! empty($options['unique'])
            && is_array($options['unique'])
        ) {
            foreach ($options['unique'] as $i => $meta) {
                $this->addUnique($i, $meta);
            }
        }

        if (! empty($options['dates'])
            && is_array($options['dates'])
        ) {
            foreach ($options['dates'] as $column => $meta) {
                $this->addDate($column, $meta);
            }
        }

        if (! empty($options['flags'])
            && is_array($options['flags'])
        ) {
            foreach ($options['flags'] as $column => $meta) {
                $this->addFlag($column, $meta);
            }
        }

        if (! empty($options['columns'])
            && is_array($options['columns'])
        ) {
            foreach ($options['columns'] as $column => $meta) {
                $this->addColumn($column, $meta);
            }
        }

        if (! empty($options['permissions'])
            && is_array($options['permissions'])
        ) {
            foreach ($options['permissions'] as $column => $meta) {
                $this->addPermission($column, $meta);
            }
        }

        if (! empty($options['status'])
            && is_array($options['status'])
        ) {
            foreach ($options['status'] as $column => $meta) {
                $this->addStatus($column, $meta);
            }
        }

        if (! empty($options['matrix'])
            && is_array($options['matrix'])
        ) {
            foreach ($options['matrix'] as $column => $meta) {
                $this->addMatrix($column, $meta);
            }
        }
        // dd([
        //     'static::class' => static::class,
        //     // '$this' => $this,
        //     '$this->matrix' => $this->matrix,
        // ]);

        if (! empty($options['ui'])
            && is_array($options['ui'])
        ) {
            foreach ($options['ui'] as $column => $meta) {
                $this->addUi($column, $meta);
            }
        }

        if (! empty($options['json'])
            && is_array($options['json'])
        ) {
            foreach ($options['json'] as $column => $meta) {
                $this->addJson($column, $meta);
            }
        }

        return $this;
    }

    public function addId(string $column, mixed $meta): self
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->skeleton()' => $this->skeleton(),
        //     '$column' => $column,
        // ]);
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.id.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->ids[$column] = new CreateId($meta);
        $this->ids[$column]->apply();

        return $this;
    }

    public function addUnique(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.unique.invalid', [
                'i' => $i,
            ]));
        }
        $this->unique[$i] = new CreateUnique($meta);
        $this->unique[$i]->apply();

        return $this;
    }

    public function addDate(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.date.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->dates[$column] = new CreateDate($meta);
        $this->dates[$column]->apply();

        return $this;
    }

    public function addFlag(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.flag.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->flags[$column] = new CreateFlag($meta);
        $this->flags[$column]->apply();
        // dump([
        //     'static::class' => static::class,
        //     // '$this' => $this,
        //     '$this->flags' => $this->flags,
        // ]);

        return $this;
    }

    public function addColumn(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.column.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->columns[$column] = new CreateColumn($meta);
        $this->columns[$column]->apply();

        return $this;
    }

    public function addPermission(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.permission.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->permissions[$column] = new CreatePermission($meta);
        $this->permissions[$column]->apply();

        return $this;
    }

    public function addStatus(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.status.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->status[$column] = new CreateStatus($meta);
        $this->status[$column]->apply();

        return $this;
    }

    public function addMatrix(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.matrix.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->matrix[$column] = new CreateMatrix($meta);
        $this->matrix[$column]->apply();
        // dump([
        //     'static::class' => static::class,
        //     // '$this' => $this,
        //     '$this->matrix' => $this->matrix,
        // ]);

        return $this;
    }

    public function addUi(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.ui.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->ui[$column] = new CreateUi($meta);
        $this->ui[$column]->apply();

        return $this;
    }

    public function addJson(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.json.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->json[$column] = new CreateJson($meta);
        $this->json[$column]->apply();

        return $this;
    }

    public function migration(): string
    {
        return $this->migration;
    }

    public function primary(): string
    {
        return $this->primary;
    }

    public function timestamps(): bool
    {
        return $this->timestamps;
    }

    public function softDeletes(): bool
    {
        return $this->timestamps;
    }

    /**
     * @return array<string, bool>
     */
    public function trash(): array
    {
        return $this->trash;
    }

    /**
     * @return array<string, CreateId>
     */
    public function ids(): array
    {
        return $this->ids;
    }

    /**
     * @return array<int, CreateUnique>
     */
    public function unique(): array
    {
        return $this->unique;
    }

    /**
     * @return array<string, CreateDate>
     */
    public function dates(): array
    {
        return $this->dates;
    }

    /**
     * @return array<string, CreateFlag>
     */
    public function flags(): array
    {
        return $this->flags;
    }

    /**
     * @return array<string, CreateColumn>
     */
    public function columns(): array
    {
        return $this->columns;
    }

    /**
     * @return array<string, CreatePermission>
     */
    public function permissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return array<string, CreateStatus>
     */
    public function status(): array
    {
        return $this->status;
    }

    /**
     * @return array<string, CreateMatrix>
     */
    public function matrix(): array
    {
        return $this->matrix;
    }

    /**
     * @return array<string, CreateUi>
     */
    public function ui(): array
    {
        return $this->ui;
    }

    /**
     * @return array<string, CreateJson>
     */
    public function json(): array
    {
        return $this->json;
    }

    public function jsonSerialize(): mixed
    {
        $properties = [
            'migration' => $this->migration(),
            'primary' => $this->primary(),
            'timestamps' => $this->timestamps(),
            'softDeletes' => $this->softDeletes(),
            'trash' => $this->trash(),
            'ids' => [],
            'unique' => [],
            'dates' => [],
            'flags' => [],
            'columns' => [],
            'permissions' => [],
            'status' => [],
            'matrix' => [],
            'ui' => [],
            'json' => [],
        ];

        if ($this->ids()) {
            foreach ($this->ids() as $column => $c) {
                if (is_array($properties['ids'])) {
                    $properties['ids'][$column] = $c->toArray();
                }
            }
        }

        // TODO FIXME unique
        // if ($this->unique()) {
        //     foreach ($this->unique() as $i => $c) {
        //         if (is_array($properties['unique'])) {
        //             $properties['unique'][$i] = $c->toArray();
        //         }
        //     }
        // }

        if ($this->dates()) {
            foreach ($this->dates() as $column => $c) {
                if (is_array($properties['dates'])) {
                    $properties['dates'][$column] = $c->toArray();
                }
            }
        }

        if ($this->flags()) {
            foreach ($this->flags() as $column => $c) {
                if (is_array($properties['flags'])) {
                    $properties['flags'][$column] = $c->toArray();
                }
            }
        }

        if ($this->columns()) {
            foreach ($this->columns() as $column => $c) {
                if (is_array($properties['columns'])) {
                    $properties['columns'][$column] = $c->toArray();
                }
            }
        }

        if ($this->permissions()) {
            foreach ($this->permissions() as $column => $c) {
                if (is_array($properties['permissions'])) {
                    $properties['permissions'][$column] = $c->toArray();
                }
            }
        }

        if ($this->status()) {
            foreach ($this->status() as $column => $c) {
                if (is_array($properties['status'])) {
                    $properties['status'][$column] = $c->toArray();
                }
            }
        }

        if ($this->matrix()) {
            foreach ($this->matrix() as $column => $c) {
                if (is_array($properties['matrix'])) {
                    $properties['matrix'][$column] = $c->toArray();
                }
            }
        }

        if ($this->ui()) {
            foreach ($this->ui() as $column => $c) {
                if (is_array($properties['ui'])) {
                    $properties['ui'][$column] = $c->toArray();
                }
            }
        }

        if ($this->json()) {
            foreach ($this->json() as $column => $c) {
                if (is_array($properties['json'])) {
                    $properties['json'][$column] = $c->toArray();
                }
            }
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->ids()' => $this->ids(),
        //     '$properties' => $properties,
        // ]);

        return $properties;
    }
}
