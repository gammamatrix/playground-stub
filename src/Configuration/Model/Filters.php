<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Playground\Stub\Configuration\Configuration;

/**
 * \Playground\Stub\Configuration\Model\Filters
 * src/Configuration/Model/Filters.php
 */
class Filters extends Configuration
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

        return $this;
    }

    public function addId(int $i, mixed $meta): self
    {
        if (empty($meta) || ! is_array($meta)) {
            throw new \RuntimeException(__('playground-stub::stub.Filters.Id.invalid', [
                'name' => $this->name,
                'i' => $i,
            ]));
        }

        $meta['handler'] = 'ids';

        $this->ids[] = new Filter($meta);

        return $this;
    }

    public function skeleton(): bool
    {
        return $this->skeleton;
    }
}
