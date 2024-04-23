<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\PrimaryProperties
 */
trait PrimaryProperties
{
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
        'type' => '',
        'uses' => [],
    ];

    protected string $class = '';

    // "config": "playground-matrix",
    protected string $config = '';

    protected string $extends = '';

    protected string $extends_use = '';

    protected string $fqdn = '';

    protected string $model = '';

    // "module": "Matrix",
    protected string $module = '';

    // "module_slug": "matrix",
    protected string $module_slug = '';

    // "name": "Matrix",
    protected string $name = '';

    // "namespace": "GammaMatrix/Playground/Matrix",
    protected string $namespace = '';

    // "organization": "GammaMatrix",
    protected string $organization = '';

    // "package": "playground-matrix",
    protected string $package = '';

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
        if (! empty($options['class'])
            && is_string($options['class'])
        ) {
            $this->class = $options['class'];
        }

        if (! empty($options['config'])
            && is_string($options['config'])
        ) {
            $this->config = $options['config'];
        }

        if (! empty($options['organization'])
            && is_string($options['organization'])
        ) {
            $this->organization = $options['organization'];
        }

        if (! empty($options['extends'])
            && is_string($options['extends'])
        ) {
            $this->extends = $options['extends'];
        }

        if (! empty($options['extends_use'])
            && is_string($options['extends_use'])
        ) {
            $this->extends_use = $options['extends_use'];
        }

        if (! empty($options['fqdn'])
            && is_string($options['fqdn'])
        ) {
            $this->fqdn = $options['fqdn'];
        }

        if (! empty($options['model'])
            && is_string($options['model'])
        ) {
            $this->model = $options['model'];
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

        if (! empty($options['name'])
            && is_string($options['name'])
        ) {
            $this->name = $options['name'];
        }

        if (! empty($options['namespace'])
            && is_string($options['namespace'])
        ) {
            $this->namespace = $options['namespace'];
        }

        if (! empty($options['package'])
            && is_string($options['package'])
        ) {
            $this->package = $options['package'];
        }

        if (! empty($options['type'])
            && is_string($options['type'])
        ) {
            $this->type = $options['type'];
        }

        if (! empty($options['uses'])
            && is_array($options['uses'])
        ) {
            foreach ($options['uses'] as $key => $class) {
                $this->addToUse(
                    $class,
                    is_string($key) ? $key : null
                );
            }
        }

        return $this;
    }

    public function class(): string
    {
        return $this->class;
    }

    public function config(): string
    {
        return $this->config;
    }

    public function fqdn(): string
    {
        return $this->fqdn;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function module(): string
    {
        return $this->module;
    }

    public function module_slug(): string
    {
        return $this->module_slug;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function namespace(): string
    {
        return $this->namespace;
    }

    public function organization(): string
    {
        return $this->organization;
    }

    public function package(): string
    {
        return $this->package;
    }

    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array<int|string, string>
     */
    public function uses(): array
    {
        return $this->uses;
    }

    public function extends(): string
    {
        return $this->extends;
    }

    public function extends_use(): string
    {
        return $this->extends_use;
    }

    /**
     * @return array<string, mixed>
     */
    public function properties(): array
    {
        return $this->properties;
    }
}
