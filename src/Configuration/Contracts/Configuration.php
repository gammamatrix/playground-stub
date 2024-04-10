<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Contracts;

/**
 * \Playground\Stub\Configuration\Contracts\Configuration
 */
interface Configuration
{
    public function class(): string;

    public function config(): string;

    public function fqdn(): string;

    public function model(): string;

    public function module(): string;

    public function module_slug(): string;

    public function name(): string;

    public function namespace(): string;

    public function organization(): string;

    public function package(): string;

    public function type(): string;

    public function apply(): self;

    public function folder(): string;

    public function setFolder(string $folder): self;

    public function getParent(): ?Configuration;

    public function setParent(Configuration $parent = null): self;

    /**
     * @return array<string, mixed>
     */
    public function properties(): array;

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self;

    public function withSkeleton(): self;

    public function skeleton(): bool;

    /**
     * @return array<int, class-string>
     */
    public function uses(): array;

    public function extends_use(): string;
}
