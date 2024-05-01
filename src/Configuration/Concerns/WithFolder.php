<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\WithFolder
 */
trait WithFolder
{
    public function folder(): string
    {
        return $this->folder;
    }

    public function setFolder(string $folder = ''): self
    {
        $this->folder = $folder;

        return $this;
    }
}
