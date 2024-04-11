<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

use JsonSerializable;

/**
 * \Playground\Stub\Configuration\Configuration
 */
class Configuration implements
    Contracts\Configuration,
    Contracts\WithParent,
    JsonSerializable
{
    use Concerns\Classes;
    use Concerns\Properties;
    use Concerns\WithParent;

    /**
     * @var string The component folder.
     */
    protected string $folder = '';

    /**
     * @var bool Allows for autogenerating sparse configurations.
     */
    protected bool $skeleton = false;

    public function __construct(
        mixed $options = null,
        bool $skeleton = null
    ) {
        if (is_bool($skeleton)) {
            $this->skeleton = $skeleton;
        }

        if (is_array($options)) {

            if (! is_bool($skeleton) && array_key_exists('skeleton', $options)) {
                $this->skeleton = ! empty($options['skeleton']);
            }

            $this->setOptions($options);
        }
    }

    public function apply(): self
    {
        foreach ($this->properties() as $property => $value) {
            if (method_exists($this, $property)) {
                $this->properties[$property] = $this->{$property}();
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return $this->properties;
    }

    public function folder(): string
    {
        return $this->folder;
    }

    public function setFolder(string $folder = ''): self
    {
        $this->folder = $folder;

        return $this;
    }

    public function skeleton(): bool
    {
        return $this->skeleton;
    }

    public function withSkeleton(): self
    {
        $this->skeleton = true;

        return $this;
    }
}
