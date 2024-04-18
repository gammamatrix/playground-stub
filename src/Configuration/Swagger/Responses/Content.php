<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Stub\Configuration\Swagger\Responses;

use Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Swagger\Responses\Content
 */
class Content extends Configuration\Configuration
{
    protected string $type = '';

    /**
     * @var array<string, mixed>
     */
    protected array $schema = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'type' => '',
        'schema' => [],
    ];

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

        if (! empty($options['schema'])
            && is_array($options['schema'])
        ) {
            $this->schema = $options['schema'];
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
    public function schema(): array
    {
        return $this->schema;
    }
}
