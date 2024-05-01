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
    JsonSerializable
{
    use Concerns\Properties;

    /**
     * @var string The component folder.
     */
    protected string $folder = '';

    public function __construct(
        mixed $options = null
    ) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function apply(): self
    {
        foreach ($this->properties() as $property => $value) {
            // dump([
            //     'static::class' => static::class,
            //     '$property' => $property,
            // ]);
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

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $properties = $this->jsonSerialize();

        return is_array($properties) ? $properties : [];
    }
}
