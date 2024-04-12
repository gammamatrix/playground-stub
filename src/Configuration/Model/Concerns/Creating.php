<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

use Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Creating
 */
trait Creating
{
    protected ?Model\Create $create = null;

    /**
     * @var array<string, class-string>
     */
    protected array $implements = [];

    /**
     * @param array<string, mixed> $options
     */
    public function addCreate(array $options): self
    {
        if (! empty($options['create'])
            && is_array($options['create'])
        ) {
            // $this->create = new Model\Create($options['create'], $this->skeleton());
            // $this->create->setParent($this)->apply();
            $this->create = new Model\Create(null, $this->skeleton());
            $this->create->setParent($this)->setOptions($options['create'])->apply();
        }

        return $this;
    }

    public function create(): ?Model\Create
    {
        return $this->create;
    }
}
