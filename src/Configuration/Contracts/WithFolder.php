<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Contracts;

/**
 * \Playground\Stub\Configuration\Contracts\WithFolder
 */
interface WithFolder
{
    public function folder(): string;

    public function setFolder(string $folder): self;
}
