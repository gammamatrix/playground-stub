<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Model\Filters
 */
class Filters extends ModelConfiguration implements Configuration\Contracts\WithSkeleton
{
    use Configuration\Concerns\WithSkeleton;

    protected ?string $builder = null;

    /**
     * @var array<int, Filter>
     */
    protected array $ids = [];

    /**
     * @var array<int, Filter>
     */
    protected array $dates = [];

    /**
     * @var array<int, Filter>
     */
    protected array $flags = [];

    /**
     * @var array<string, bool>
     */
    protected array $trash = [
        'hide' => true,
        'only' => true,
        'with' => true,
    ];

    /**
     * @var array<int, Filter>
     */
    protected array $columns = [];

    /**
     * @var array<int, Filter>
     */
    protected array $permissions = [];

    /**
     * @var array<int, Filter>
     */
    protected array $status = [];

    /**
     * @var array<int, Filter>
     */
    protected array $matrix = [];

    /**
     * @var array<int, Filter>
     */
    protected array $ui = [];

    /**
     * @var array<int, Filter>
     */
    protected array $json = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'builder' => null,
        'ids' => [],
        'dates' => [],
        'flags' => [],
        'trash' => [],
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
        parent::setOptions($options);

        if (! empty($options['builder'])
            && is_string($options['builder'])
        ) {
            $this->builder = $options['builder'];
        }

        if (! empty($options['ids'])
            && is_array($options['ids'])
        ) {
            foreach ($options['ids'] as $i => $meta) {
                $this->addId($i, $meta);
            }
        }

        if (! empty($options['dates'])
            && is_array($options['dates'])
        ) {
            foreach ($options['dates'] as $i => $meta) {
                $this->addDate($i, $meta);
            }
        }

        if (! empty($options['flags'])
            && is_array($options['flags'])
        ) {
            foreach ($options['flags'] as $i => $meta) {
                $this->addFlag($i, $meta);
            }
        }

        if (! empty($options['trash'])
            && is_array($options['trash'])
        ) {
            $this->handleTrash($options['trash']);
        }

        if (! empty($options['columns'])
            && is_array($options['columns'])
        ) {
            foreach ($options['columns'] as $i => $meta) {
                $this->addColumn($i, $meta);
            }
        }

        if (! empty($options['permissions'])
            && is_array($options['permissions'])
        ) {
            foreach ($options['permissions'] as $i => $meta) {
                $this->addPermission($i, $meta);
            }
        }

        if (! empty($options['status'])
            && is_array($options['status'])
        ) {
            foreach ($options['status'] as $i => $meta) {
                $this->addStatus($i, $meta);
            }
        }

        if (! empty($options['matrix'])) {
            $this->addMatrix();
        }

        if (! empty($options['ui'])
            && is_array($options['ui'])
        ) {
            foreach ($options['ui'] as $i => $meta) {
                $this->addUi($i, $meta);
            }
        }

        if (! empty($options['json'])
            && is_array($options['json'])
        ) {
            foreach ($options['json'] as $i => $meta) {
                $this->addJson($i, $meta);
            }
        }

        return $this;
    }

    public function addId(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Id.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'ids';

        $this->ids[$i] = new Filter(null);
        $this->ids[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addDate(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Date.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'dates';

        $this->dates[$i] = new Filter(null);
        $this->dates[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addFlag(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Flag.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'flags';

        $this->flags[$i] = new Filter(null);
        $this->flags[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function handleTrash(mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Trash.invalid'));
        }

        $this->trash['hide'] = ! empty($meta['hide']);
        $this->trash['only'] = ! empty($meta['only']);
        $this->trash['with'] = ! empty($meta['with']);

        return $this;
    }

    public function addColumn(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Column.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'columns';

        $this->columns[$i] = new Filter(null);
        $this->columns[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addMatrix(): self
    {
        $meta['handler'] = 'matrix';

        $columns = [
            'matrix' => [
                'label' => 'Matrix',
                'nullable' => true,
                'type' => 'JSON_OBJECT',
            ],
            'x' => [
                'label' => 'x',
                // 'type' => 'bigInteger',
                'type' => 'integer',
                'nullable' => true,
                'unsigned' => false,
            ],
            'y' => [
                'label' => 'y',
                // 'type' => 'bigInteger',
                'type' => 'integer',
                'nullable' => true,
                'unsigned' => false,
            ],
            'z' => [
                'label' => 'z',
                // 'type' => 'bigInteger',
                'type' => 'integer',
                'nullable' => true,
                'unsigned' => false,
            ],
            'r' => [
                'label' => 'r',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 65,
                'scale' => 10,
                'nullable' => true,
                'default' => null,
            ],
            'theta' => [
                'label' => 'θ',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 10,
                'scale' => 6,
                'nullable' => true,
                'default' => null,
            ],
            'rho' => [
                'label' => 'ρ',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 10,
                'scale' => 6,
                'nullable' => true,
                'default' => null,
            ],
            'phi' => [
                'label' => 'φ',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 10,
                'scale' => 6,
                'nullable' => true,
                'default' => null,
            ],
            'elevation' => [
                'label' => 'Elevation',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 65,
                'scale' => 10,
                'nullable' => true,
                'default' => null,
            ],
            'latitude' => [
                'label' => 'Latitude',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 8,
                'scale' => 6,
                'nullable' => true,
                'default' => null,
            ],
            'longitude' => [
                'label' => 'Longitude',
                // 'type' => 'decimal',
                'type' => 'float',
                'precision' => 9,
                'scale' => 6,
                'nullable' => true,
                'default' => null,
            ],
        ];

        $i = 0;
        foreach ($columns as $column => $meta) {
            $meta['column'] = $column;
            $this->matrix[$i] = new Filter(null);
            $this->matrix[$i]->setParent($this)->setOptions($meta)->apply();
            $i++;
        }

        return $this;
    }

    public function addPermission(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Permission.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'permissions';

        $this->permissions[$i] = new Filter(null);
        $this->permissions[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addStatus(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Status.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'status';

        $this->status[$i] = new Filter(null);
        $this->status[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addUi(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Ui.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'ui';

        $this->ui[$i] = new Filter(null);
        $this->ui[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addJson(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Json.invalid', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'json';

        $this->json[$i] = new Filter(null);
        $this->json[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function builder(): ?string
    {
        return $this->builder;
    }

    /**
     * @return array<int, Filter>
     */
    public function ids(): array
    {
        return $this->ids;
    }

    /**
     * @return array<int, Filter>
     */
    public function dates(): array
    {
        return $this->dates;
    }

    /**
     * @return array<int, Filter>
     */
    public function flags(): array
    {
        return $this->flags;
    }

    /**
     * @return array<int, Filter>
     */
    public function columns(): array
    {
        return $this->columns;
    }

    /**
     * @return array<int, Filter>
     */
    public function matrix(): array
    {
        return $this->matrix;
    }

    /**
     * @return array<string, bool>
     */
    public function trash(): array
    {
        return $this->trash;
    }

    /**
     * @return array<int, Filter>
     */
    public function permissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return array<int, Filter>
     */
    public function status(): array
    {
        return $this->status;
    }

    /**
     * @return array<int, Filter>
     */
    public function ui(): array
    {
        return $this->ui;
    }

    /**
     * @return array<int, Filter>
     */
    public function json(): array
    {
        return $this->json;
    }

    public function jsonSerialize(): mixed
    {
        $properties = [
            'builder' => $this->builder(),
            'ids' => [],
            'dates' => [],
            'flags' => [],
            'trash' => $this->trash(),
            'columns' => [],
            'permissions' => [],
            'status' => [],
            'matrix' => [],
            'ui' => [],
            'json' => [],
        ];

        if ($this->ids()) {
            foreach ($this->ids() as $i => $id) {
                if (is_array($properties['ids'])) {
                    $properties['ids'][$i] = $id->toArray();
                }
            }
        }

        if ($this->dates()) {
            foreach ($this->dates() as $i => $date) {
                if (is_array($properties['dates'])) {
                    $properties['dates'][$i] = $date->toArray();
                }
            }
        }

        if ($this->flags()) {
            foreach ($this->flags() as $i => $flag) {
                if (is_array($properties['flags'])) {
                    $properties['flags'][$i] = $flag->toArray();
                }
            }
        }

        if ($this->columns()) {
            foreach ($this->columns() as $i => $column) {
                if (is_array($properties['columns'])) {
                    $properties['columns'][$i] = $column->toArray();
                }
            }
        }

        if ($this->permissions()) {
            foreach ($this->permissions() as $i => $permission) {
                if (is_array($properties['permissions'])) {
                    $properties['permissions'][$i] = $permission->toArray();
                }
            }
        }

        if ($this->status()) {
            foreach ($this->status() as $i => $status) {
                if (is_array($properties['status'])) {
                    $properties['status'][$i] = $status->toArray();
                }
            }
        }

        if ($this->matrix()) {
            foreach ($this->matrix() as $i => $matrix) {
                if (is_array($properties['matrix'])) {
                    $properties['matrix'][$i] = $matrix->toArray();
                }
            }
        }

        if ($this->ui()) {
            foreach ($this->ui() as $i => $ui) {
                if (is_array($properties['ui'])) {
                    $properties['ui'][$i] = $ui->toArray();
                }
            }
        }

        if ($this->json()) {
            foreach ($this->json() as $i => $json) {
                if (is_array($properties['json'])) {
                    $properties['json'][$i] = $json->toArray();
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
