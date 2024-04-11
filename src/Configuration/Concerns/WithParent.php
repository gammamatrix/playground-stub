<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\WithParent
 */
trait WithParent
{
    public function getParent(): ?\Playground\Stub\Configuration\Configuration
    {
        return property_exists($this, '_parent') ? $this->_parent : null;
    }

    public function setParent(\Playground\Stub\Configuration\Configuration $parent = null): self
    {
        if (property_exists($this, '_parent')) {
            $this->_parent = $parent;
        }

        return $this;
    }
}
