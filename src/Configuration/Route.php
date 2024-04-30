<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Route
 */
class Route extends PrimaryConfiguration
{
    protected string $controller = '';

    protected string $model_column = '';

    protected string $model_fqdn = '';

    protected string $model_label = '';

    protected string $model_slug = '';

    protected string $model_slug_plural = '';

    protected string $module = '';

    protected string $module_slug = '';

    protected string $route = '';

    protected string $route_prefix = '';

    protected string $title = '';

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
        'controller' => '',
        'extends' => '',
        // 'folder' => '',
        'models' => [],
        'model' => '',
        'model_column' => '',
        'model_fqdn' => '',
        'model_label' => '',
        'model_slug' => '',
        'model_slug_plural' => '',
        'type' => '',
        'route' => '',
        'route_prefix' => '',
        // 'base_route' => 'welcome',
        'title' => '',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['controller'])
            && is_string($options['controller'])
        ) {
            $this->controller = $options['controller'];
        }

        if (! empty($options['model_column'])
            && is_string($options['model_column'])
        ) {
            $this->model_column = $options['model_column'];
        }

        if (! empty($options['model_fqdn'])
            && is_string($options['model_fqdn'])
        ) {
            $this->model_fqdn = $options['model_fqdn'];
        }

        if (! empty($options['model_label'])
            && is_string($options['model_label'])
        ) {
            $this->model_label = $options['model_label'];
        }

        if (! empty($options['model_slug_plural'])
            && is_string($options['model_slug_plural'])
        ) {
            $this->model_slug_plural = $options['model_slug_plural'];
        }

        if (! empty($options['module'])
            && is_string($options['module'])
        ) {
            $this->module = $options['module'];
        }

        if (! empty($options['module_slug'])
            && is_string($options['module_slug'])
        ) {
            $this->module_slug = $options['module_slug'];
        }

        if (! empty($options['route'])
            && is_string($options['route'])
        ) {
            $this->route = $options['route'];
        }

        if (! empty($options['route'])
            && is_string($options['route'])
        ) {
            $this->route = $options['route'];
        }

        if (! empty($options['route_prefix'])
            && is_string($options['route_prefix'])
        ) {
            $this->route_prefix = $options['route_prefix'];
        }

        if (! empty($options['title'])
            && is_string($options['title'])
        ) {
            $this->title = $options['title'];
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

    public function controller(): string
    {
        return $this->controller;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }

    public function model_column(): string
    {
        return $this->model_column;
    }

    public function model_fqdn(): string
    {
        return $this->model_fqdn;
    }

    public function model_label(): string
    {
        return $this->model_label;
    }

    public function model_slug(): string
    {
        return $this->model_slug;
    }

    public function model_slug_plural(): string
    {
        return $this->model_slug_plural;
    }

    public function module(): string
    {
        return $this->module;
    }

    public function module_slug(): string
    {
        return $this->module_slug;
    }

    public function route(): string
    {
        return $this->route;
    }

    public function route_prefix(): string
    {
        return $this->route_prefix;
    }

    public function title(): string
    {
        return $this->title;
    }
}
