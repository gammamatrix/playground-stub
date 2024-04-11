<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Contracts;

/**
 * \Playground\Stub\Configuration\Contracts\WithParent
 */
interface WithParent
{
    public function getParent(): ?\Playground\Stub\Configuration\Configuration;

    public function setParent(\Playground\Stub\Configuration\Configuration $parent = null): self;
}
