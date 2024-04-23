<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\WithSkeleton
 */
trait WithSkeleton
{
    protected bool $skeleton = false;

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
