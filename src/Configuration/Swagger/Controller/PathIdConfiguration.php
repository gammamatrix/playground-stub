<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Stub\Configuration\Swagger\Controller;

use Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Swagger\PathIdConfiguration
 */
class PathIdConfiguration extends Configuration\Configuration
{
    protected ?PathId $_parent = null;

    public function getParent(): ?PathId
    {
        return $this->_parent;
    }

    public function setParent(PathId $parent = null): self
    {
        $this->_parent = $parent;

        return $this;
    }
}
