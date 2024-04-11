<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Model\ModelConfiguration
 */
class ModelConfiguration extends Configuration\Configuration
{
    protected ?Configuration\Model $_parent = null;

    public function getParent(): ?Configuration\Model
    {
        return $this->_parent;
    }

    public function setParent(Configuration\Model $parent = null): self
    {
        $this->_parent = $parent;

        return $this;
    }
}
