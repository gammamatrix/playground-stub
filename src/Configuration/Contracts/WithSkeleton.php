<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Contracts;

/**
 * \Playground\Stub\Configuration\Contracts\WithSkeleton
 */
interface WithSkeleton
{
    public function withSkeleton(): self;

    public function skeleton(): bool;
}
