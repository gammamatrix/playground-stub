<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

use JsonSerializable;

/**
 * \Playground\Stub\Configuration
 */
class Configuration implements JsonSerializable
{
    use Concerns\Classes;
    use Concerns\Properties;

    /**
     * @var bool Allows for autogenerating sparse configurations.
     */
    protected bool $skeleton = false;

    public function __construct(
        mixed $options = null
    ) {
        if (is_array($options)) {

            if (array_key_exists('skeleton', $options)) {
                $this->skeleton = ! empty($options['skeleton']);
            }

            $this->setOptions($options);
        }
    }

    public function jsonSerialize(): mixed
    {
        return $this->properties;
    }

    public function skeleton(): bool
    {
        return $this->skeleton;
    }
}
