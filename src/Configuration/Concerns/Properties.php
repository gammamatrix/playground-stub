<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\Properties
 */
trait Properties
{
    /**
     * @var array<string, mixed>
     */
    protected $properties = [];

    protected string $type = '';

    /**
     * @var array<int|string, string>
     */
    protected array $uses = [];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['type'])
            && is_string($options['type'])
        ) {
            $this->type = $options['type'];
        }

        return $this;
    }

    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed>
     */
    public function properties(): array
    {
        return $this->properties;
    }
}
