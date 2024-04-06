<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Playground\Stub\Configuration\Configuration;

/**
 * \Playground\Stub\Configuration\Filter
 */
class Filter extends Configuration
{
    protected string $column = '';

    protected string $handler = '';

    protected string $label = '';

    protected string $icon = '';

    protected bool $nullable = false;

    protected string $type = 'string';

    protected bool $unsigned = true;

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'column' => '',
        'label' => '',
        'icon' => '',
        'nullable' => false,
        'unsigned' => true,
        'type' => '',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['column'])
            && is_string($options['column'])
        ) {
            $this->column = $options['column'];
        }

        if (! empty($options['handler'])
            && is_string($options['handler'])
        ) {
            $this->handler = $options['handler'];
        }

        if (! empty($options['label'])
            && is_string($options['label'])
        ) {
            $this->label = $options['label'];
        }

        if (! empty($options['icon'])
            && is_string($options['icon'])
        ) {
            $this->icon = $options['icon'];
        }

        if (array_key_exists('nullable', $options)) {
            $this->nullable = ! empty($options['nullable']);
        }

        if (array_key_exists('unsigned', $options)) {
            $this->unsigned = ! empty($options['unsigned']);
        }

        if (! empty($options['type'])
            && is_string($options['type'])
        ) {
            $this->type = $options['type'];
        }

        return $this;
    }

    public function column(): string
    {
        return $this->column;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function icon(): string
    {
        return $this->icon;
    }

    public function nullable(): bool
    {
        return $this->nullable;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function unsigned(): bool
    {
        return $this->unsigned;
    }
}
