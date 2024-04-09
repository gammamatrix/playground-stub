<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Illuminate\Support\Facades\Log;
use Playground\Stub\Configuration\Configuration;

/**
 * \Playground\Stub\Configuration\Model\Create
 */
class Create extends Configuration
{
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
        'ui' => [],
        'json' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (array_key_exists('skeleton', $options)) {
            $this->skeleton = ! empty($options['skeleton']);
        }

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

        if (! empty($options['ids'])
            && is_array($options['ids'])
        ) {
            foreach ($options['ids'] as $column => $meta) {
                $this->addId($column, $meta);
            }
        }

        return $this;
    }

    public function addId(string $column, mixed $meta): self
    {
        if (empty($column) || empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Create.id.invalid', [
                'column' => $column,
            ]));
        }
        $meta['column'] = $column;
        $this->ids[$column] = new CreateId($meta, $this->skeleton());

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
}
