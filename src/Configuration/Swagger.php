<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Swagger
 */
class Swagger extends Configuration
{
    protected string $controller_type = '';

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
        'type' => '',
        'controller_type' => '',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['controller_type'])
            && is_string($options['controller_type'])
        ) {
            $this->controller_type = $options['controller_type'];
        }

        return $this;
    }

    public function controller_type(): string
    {
        return $this->controller_type;
    }
}
