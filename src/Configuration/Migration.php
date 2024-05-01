<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Migration
 */
class Migration extends PrimaryConfiguration
{
    protected bool $create = false;

    protected bool $update = false;

    protected string $table = '';

    protected string $model_fqdn = '';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'config' => '',
        // 'extends' => '',
        // 'fqdn' => '',
        // 'extends_use' => '',
        'model' => '',
        'model_fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'table' => '',
        'type' => '',
        'models' => [],
        // 'uses' => [],
        'create' => false,
        'update' => false,
    ];

    /**
     * @var array<string, string>
     */
    protected array $models = [];

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

        if (! empty($options['model_fqdn'])
            && is_string($options['model_fqdn'])
        ) {
            $this->model_fqdn = $options['model_fqdn'];
        }

        if (! empty($options['table'])
            && is_string($options['table'])
        ) {
            $this->table = $options['table'];
        }

        if (array_key_exists('create', $options)) {
            $this->create = ! empty($options['create']);
        }

        if (array_key_exists('update', $options)) {
            $this->update = ! empty($options['update']);
        }

        $this->addModels($options);

        return $this;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function addModels(array $options): self
    {
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

    public function create(): bool
    {
        return $this->create;
    }

    public function update(): bool
    {
        return $this->update;
    }
}
