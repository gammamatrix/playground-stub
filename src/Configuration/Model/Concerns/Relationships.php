<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

use Playground\Stub\Configuration\Model\HasMany;
use Playground\Stub\Configuration\Model\HasOne;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Relationships
 */
trait Relationships
{
    /**
     * @var array<string, HasOne>
     */
    protected array $HasOne = [];

    /**
     * @var array<string, HasMany>
     */
    protected array $HasMany = [];

    /**
     * @param array<string, mixed> $options
     */
    public function addRelationships(array $options): self
    {
        if (! empty($options['HasOne'])
            && is_array($options['HasOne'])
        ) {
            foreach ($options['HasOne'] as $accessor => $meta) {
                if (empty($accessor) || ! is_string($accessor)) {
                    $parent = $this->getParent();
                    throw new \RuntimeException(__('playground-stub::stub.Model.HasOne.invalid', [
                        'name' => $parent ? $parent->name() : 'model',
                        'accessor' => is_string($accessor) ? $accessor : gettype($accessor),
                    ]));
                }
                if (is_string($accessor)) {
                    $this->addHasOne($accessor, $meta);
                }
            }
        }

        if (! empty($options['HasMany'])
            && is_array($options['HasMany'])
        ) {
            foreach ($options['HasMany'] as $accessor => $meta) {
                if (empty($accessor) || ! is_string($accessor)) {
                    $parent = $this->getParent();
                    throw new \RuntimeException(__('playground-stub::stub.Model.HasMany.invalid', [
                        'name' => $parent ? $parent->name() : 'model',
                        'accessor' => is_string($accessor) ? $accessor : gettype($accessor),
                    ]));
                }
                if (is_string($accessor)) {
                    $this->addHasMany($accessor, $meta);
                }
            }
        }

        return $this;
    }

    public function addHasOne(
        string $accessor,
        mixed $meta
    ): self {

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        if ($accessor) {
            if (empty($meta['accessor'])) {
                $meta['accessor'] = $accessor;
            }

            $this->HasOne[$accessor] = new HasOne;

            if ($this->skeleton()) {
                $this->HasOne[$accessor]->withSkeleton();
            }

            $this->HasOne[$accessor]->setParent($this)->setOptions($meta)->apply();
        }

        return $this;
    }

    public function addHasMany(
        string $accessor,
        mixed $meta
    ): self {

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        if ($accessor) {
            if (empty($meta['accessor'])) {
                $meta['accessor'] = $accessor;
            }

            $this->HasMany[$accessor] = new HasMany;

            if ($this->skeleton()) {
                $this->HasMany[$accessor]->withSkeleton();
            }

            $this->HasMany[$accessor]->setParent($this)->setOptions($meta)->apply();
        }

        return $this;
    }

    /**
     * @return array<string, HasOne>
     */
    public function HasOne(): array
    {
        return $this->HasOne;
    }

    /**
     * @return array<string, HasMany>
     */
    public function HasMany(): array
    {
        return $this->HasMany;
    }
}
