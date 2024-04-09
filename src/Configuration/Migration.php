<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Migration
 */
class Migration extends Configuration
{
    protected string $table = '';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'config' => '',
        'extends' => '',
        'fqdn' => '',
        'extends_use' => '',
        'model' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'table' => '',
        'type' => '',
        'uses' => [],
    ];

    public function table(): string
    {
        return $this->table;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['table'])
            && is_string($options['table'])
        ) {
            $this->table = $options['table'];
        }

        return $this;
    }
}
