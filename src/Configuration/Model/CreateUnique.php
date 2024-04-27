<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\CreateUnique
 */
class CreateUnique extends ModelConfiguration
{
    /**
     * @var array<int, string>
     */
    protected array $keys = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'keys' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['keys'])
            && is_array($options['keys'])
        ) {
            foreach ($options['keys'] as $i => $key) {
                if (is_int($i) && is_string($key) && ! in_array($key, $this->keys)) {
                    $this->keys[] = $key;
                }
            }
        }

        // dd($options);
        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function keys(): array
    {
        return $this->keys;
    }
}
