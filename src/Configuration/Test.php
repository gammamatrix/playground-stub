<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Test
 */
class Test extends Configuration
{
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
        'model' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'type' => '',
        'uses' => [],

        // properties

        'extends' => '',

        'model_fqdn' => '',

        'models' => [],

        // 'organization' => '',
        // 'package' => 'app',
        // 'fqdn' => '',
        // 'namespace' => '',
        // 'model' => '',
        // 'model_column' => '',
        // 'model_label' => '',
        // 'module' => '',
        // 'module_slug' => '',
        // 'name' => '',
        // 'folder' => '',
        // 'class' => '',
        // 'type' => '',
        // 'table' => '',
        // 'extends' => '\Tests\TestCase',
        // 'implements' => [],
        // 'properties' => [],
        // 'setup' => [],
        // 'tests' => [],
        // 'HasOne' => [],
        // 'HasMany' => [],
        // 'uses' => [],

    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['models'])
            && is_array($options['models'])
        ) {
            foreach ($options['models'] as $key => $file) {
                $this->addMappedClassTo('models', $key, $file);
            }
        }

        return $this;
    }

    public function model_fqdn(): string
    {
        return $this->model_fqdn;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }
}
