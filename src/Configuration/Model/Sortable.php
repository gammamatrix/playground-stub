<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\Sortable
 */
class Sortable extends ModelConfiguration
{
    protected string $column = '';

    protected string $label = '';

    protected string $icon = '';

    protected bool $nullable = false;

    protected string $type = 'string';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'column' => '',
        'label' => '',
        'icon' => '',
        'nullable' => false,
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
}
