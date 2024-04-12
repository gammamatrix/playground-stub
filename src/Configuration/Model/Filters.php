<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\Filters
 */
class Filters extends ModelConfiguration
{
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
    protected array $ui = [];

    /**
     * @var array<int, Filter>
     */
    protected array $json = [];

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

        $this->ids[$i] = new Filter(null, $this->skeleton());
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

        $this->dates[$i] = new Filter(null, $this->skeleton());
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

        $this->flags[$i] = new Filter(null, $this->skeleton());
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
            throw new \RuntimeException(__('playground-stub::stub.Filters.Column.invalcolumn', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'columns';

        $this->columns[$i] = new Filter(null, $this->skeleton());
        $this->columns[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function addPermission(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Permission.invalpermission', [
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'permissions';

        $this->permissions[$i] = new Filter(null, $this->skeleton());
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

        $this->status[$i] = new Filter(null, $this->skeleton());
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

        $this->ui[$i] = new Filter(null, $this->skeleton());
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

        $this->json[$i] = new Filter(null, $this->skeleton());
        $this->json[$i]->setParent($this)->setOptions($meta)->apply();

        return $this;
    }

    public function builder(): ?string
    {
        return $this->builder;
    }
}
