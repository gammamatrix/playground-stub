<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Template
 */
class Template extends PrimaryConfiguration
{
    protected string $model_column = '';

    protected string $model_label = '';

    protected string $route = '';

    protected string $title = '';

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
        'extends' => '',
        'folder' => '',
        'model' => '',
        'model_column' => '',
        'model_label' => '',
        'type' => '',
        'route' => '',
        'title' => '',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['model_column'])
            && is_string($options['model_column'])
        ) {
            $this->model_column = $options['model_column'];
        }

        if (! empty($options['model_label'])
            && is_string($options['model_label'])
        ) {
            $this->model_label = $options['model_label'];
        }

        if (! empty($options['route'])
            && is_string($options['route'])
        ) {
            $this->route = $options['route'];
        }

        if (! empty($options['title'])
            && is_string($options['title'])
        ) {
            $this->title = $options['title'];
        }

        if (! empty($options['folder'])
            && is_string($options['folder'])
        ) {
            $this->folder = $options['folder'];
        }

        return $this;
    }

    public function model_column(): string
    {
        return $this->model_column;
    }

    public function model_label(): string
    {
        return $this->model_label;
    }

    public function route(): string
    {
        return $this->route;
    }

    public function title(): string
    {
        return $this->title;
    }
}
