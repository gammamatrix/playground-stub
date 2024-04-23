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
class PrimaryConfiguration implements
    Contracts\PrimaryConfiguration,
    Contracts\WithFolder,
    Contracts\WithSkeleton,
    JsonSerializable
{
    use Concerns\Classes;
    use Concerns\PrimaryProperties;
    use Concerns\WithFolder;
    use Concerns\WithSkeleton;

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
