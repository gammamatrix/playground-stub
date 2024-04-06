<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Configuration\Concerns\Relationships
 */
trait Relationships
{
    /**
     * @param array<string, mixed> $options
     */
    public function addRelationships(array $options): self
    {
        if (! empty($options['HasOne'])
            && is_array($options['HasOne'])
        ) {
            foreach ($options['HasOne'] as $method => $meta) {
                $this->addHasOne($method, $meta);
            }
        }

        if (! empty($options['HasMany'])
            && is_array($options['HasMany'])
        ) {
            foreach ($options['HasMany'] as $method => $meta) {
                $this->addHasMany($method, $meta);
            }
        }

        return $this;
    }

    public function addHasOne(
        mixed $method,
        mixed $meta
    ): self {

        if (empty($method) || ! is_string($method)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.HasOne.invalid', [
                'name' => $this->name(),
                'method' => is_string($method) ? $method : gettype($method),
            ]));
        }

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        if ($this->skeleton()) {

            if (empty($meta['comment']) || ! is_string($meta['comment'])) {
                $meta['comment'] = sprintf(
                    'The %1$s of the %2$s.',
                    Str::of($method)->kebab()->replace('-', ' ')->toString(),
                    Str::of($this->name())->kebab()->replace('-', ' ')->toString()
                );
            }

            if (empty($meta['foreignKey']) || ! is_string($meta['foreignKey'])) {
                $meta['foreignKey'] = 'id';
            }

            if (empty($meta['localKey']) || ! is_string($meta['localKey'])) {
                $meta['localKey'] = Str::of($method)->snake()->finish('_id')->toString();
            }

            if (empty($meta['related']) || ! is_string($meta['related'])) {
                $meta['related'] = Str::of($method)->studly()->toString();
            }
        }

        $this->HasOne[$method] = [
            'comment' => empty($meta['comment']) || ! is_string($meta['comment']) ? '' : $meta['comment'],
            'foreignKey' => empty($meta['foreignKey']) || ! is_string($meta['foreignKey']) ? '' : $meta['foreignKey'],
            'localKey' => empty($meta['localKey']) || ! is_string($meta['localKey']) ? '' : $meta['localKey'],
            'related' => empty($meta['related']) || ! is_string($meta['related']) ? '' : $meta['related'],
        ];

        return $this;
    }

    public function addHasMany(
        mixed $method,
        mixed $meta
    ): self {

        if (empty($method) || ! is_string($method)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.HasMany.invalid', [
                'name' => $this->name(),
                'method' => is_string($method) ? $method : gettype($method),
            ]));
        }

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        if ($this->skeleton()) {

            if (empty($meta['comment']) || ! is_string($meta['comment'])) {
                $meta['comment'] = sprintf(
                    'The %1$s of the %2$s.',
                    Str::of($method)->kebab()->replace('-', ' ')->toString(),
                    Str::of($this->name())->kebab()->replace('-', ' ')->toString()
                );
            }

            if (empty($meta['foreignKey']) || ! is_string($meta['foreignKey'])) {
                $meta['localKey'] = 'id';
            }

            if (empty($meta['foreignKey']) || ! is_string($meta['foreignKey'])) {
                $meta['foreignKey'] = Str::of($method)->snake()->finish('_id')->toString();
            }

            if (empty($meta['related']) || ! is_string($meta['related'])) {
                $meta['related'] = Str::of($method)->studly()->singular()->toString();
            }
        }

        $this->HasMany[$method] = [
            'comment' => empty($meta['comment']) || ! is_string($meta['comment']) ? '' : $meta['comment'],
            'foreignKey' => empty($meta['foreignKey']) || ! is_string($meta['foreignKey']) ? '' : $meta['foreignKey'],
            'localKey' => empty($meta['localKey']) || ! is_string($meta['localKey']) ? '' : $meta['localKey'],
            'related' => empty($meta['related']) || ! is_string($meta['related']) ? '' : $meta['related'],
        ];

        return $this;
    }
}
