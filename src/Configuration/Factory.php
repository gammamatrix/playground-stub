<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Factory
 */
class Factory extends Configuration
{
    protected string $model = '';

    protected string $model_fqdn = '';

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
        'model' => '',
        'model_fqdn' => '',
        'type' => '',
    ];

    public function model(): string
    {
        return $this->model;
    }

    public function model_fqdn(): string
    {
        return $this->model_fqdn;
    }
}
