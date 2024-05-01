<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Classes
 */
trait Classes
{
    protected string $extends = '';

    /**
     * @var array<string, class-string>
     */
    protected array $implements = [];

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @param array<string, mixed> $options
     */
    public function addExtends(array $options): self
    {
        if (! empty($options['extends'])
            && is_string($options['extends'])
        ) {
            $this->extends = $options['extends'];
        }

        return $this;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function addImplements(array $options): self
    {
        if (! empty($options['implements'])
            && is_array($options['implements'])
        ) {
            foreach ($options['implements'] as $key => $fqdn) {
                $this->addMappedClassTo('implements', $key, $fqdn);
            }
        }

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

    public function extends(): string
    {
        return $this->extends;
    }

    /**
     * @return array<string, class-string>
     */
    public function implements(): array
    {
        return $this->implements;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }
}
