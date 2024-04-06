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
    protected $properties = [
        // "class": "ServiceProvider",
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
    ];

    protected string $class = '';

    // "config": "playground-matrix",
    protected string $config = '';

    protected string $fqdn = '';

    // "package": "playground-matrix",
    protected string $package = '';

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

        if (! empty($options['fqdn'])
            && is_string($options['fqdn'])
        ) {
            $this->fqdn = $options['fqdn'];
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

        if (! empty($options['package'])
            && is_string($options['package'])
        ) {
            $this->package = $options['package'];
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
}
