<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Resource
 */
class Resource extends Configuration
{
    protected bool $collection = false;

    protected string $model = '';

    protected string $model_fqdn = '';

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'collection' => false,
        // 'model' => '',
        // 'model_fqdn' => '',
        // 'type' => '',
        // 'models' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('collection', $options)) {
            $this->collection = ! empty($options['collection']);
        }

        return $this;
    }

    public function collection(): bool
    {
        return $this->collection;
    }
}
