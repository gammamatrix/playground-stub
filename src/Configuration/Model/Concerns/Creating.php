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
    public function addCreate(array $options = []): Model\Create
    {
        if (empty($this->create)) {
            $this->create = new Model\Create;
        }

        if ($this->skeleton()) {
            $this->create->withSkeleton();
        }

        $this->create->setParent($this);

        if (! empty($options['create'])
            && is_array($options['create'])
        ) {
            $this->create->setOptions($options['create']);
        }

        $this->create->apply();

        return $this->create;
    }

    public function create(): ?Model\Create
    {
        return $this->create;
    }
}
