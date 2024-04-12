<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Components
 */
trait Components
{
    protected bool $factory = false;

    protected bool $migration = false;

    protected bool $policy = false;

    protected bool $seed = false;

    protected bool $test = false;

    /**
     * @param array<string, mixed> $options
     */
    public function addComponents(array $options): self
    {
        if (array_key_exists('factory', $options)) {
            $this->factory = ! empty($options['factory']);
        }

        if (array_key_exists('migration', $options)) {
            $this->migration = ! empty($options['migration']);
        }

        if (array_key_exists('policy', $options)) {
            $this->policy = ! empty($options['policy']);
        }

        if (array_key_exists('seed', $options)) {
            $this->seed = ! empty($options['seed']);
        }

        if (array_key_exists('test', $options)) {
            $this->test = ! empty($options['test']);
        }

        return $this;
    }

    public function factory(): bool
    {
        return $this->factory;
    }

    public function migration(): bool
    {
        return $this->migration;
    }

    public function policy(): bool
    {
        return $this->policy;
    }

    public function seed(): bool
    {
        return $this->seed;
    }

    public function test(): bool
    {
        return $this->test;
    }
}
