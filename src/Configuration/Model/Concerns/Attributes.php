<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Attributes
 */
trait Attributes
{
    /**
     * @param array<string, mixed> $options
     */
    public function addModelProperties(array $options): self
    {
        if (! empty($options['attributes'])
            && is_array($options['attributes'])
        ) {
            foreach ($options['attributes'] as $attribute => $value) {
                $this->addAttribute($attribute, $value);
            }
        }

        if (! empty($options['casts'])
            && is_array($options['casts'])
        ) {
            foreach ($options['casts'] as $attribute => $value) {
                $this->addCast($attribute, $value);
            }
        }

        if (! empty($options['fillable'])
            && is_array($options['fillable'])
        ) {
            foreach ($options['fillable'] as $column) {
                $this->addFillable($column);
            }
        }

        return $this;
    }

    public function addAttribute(
        mixed $column,
        mixed $value
    ): self {

        if (empty($column) || ! is_string($column)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Attributes.invalid', [
                'name' => $this->name() ?: 'model',
                'column' => is_string($column) ? $column : gettype($column),
            ]));
        }

        if (is_null($value)) {
            $this->attributes[$column] = $value;
        } elseif (in_array(gettype($value), [
            'string',
            'integer',
            'double',
            'boolean',
        ])) {
            $this->attributes[$column] = $value;
        } else {
            $this->attributes[$column] = '';
        }

        return $this;
    }

    public function addCast(
        mixed $column,
        mixed $cast
    ): self {

        if (empty($column) || ! is_string($column)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Casts.invalid', [
                'name' => $this->name() ?: 'model',
                'column' => is_string($column) ? $column : gettype($column),
            ]));
        }

        if (! is_string($cast)) {
            $this->casts[$column] = 'string';
        } elseif (in_array($cast, [
            'datetime',
            'dateTime',
            'timestamp',
        ])) {
            $this->casts[$column] = 'datetime';
        } elseif (in_array($cast, [
            'integer',
            'bigInteger',
            'mediumInteger',
            'smallInteger',
            'tinyInteger',
        ])) {
            $this->casts[$column] = 'integer';
        } elseif (in_array($cast, [
            'bool',
            'boolean',
        ])) {
            $this->casts[$column] = 'boolean';
        } elseif (! empty($cast)) {
            $this->casts[$column] = $cast;
        }

        return $this;
    }

    public function addFillable(mixed $column): self
    {
        if (empty($column) || ! is_string($column)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Fillable.invalid', [
                'name' => $this->name() ?: 'model',
                'column' => is_string($column) ? $column : gettype($column),
            ]));
        }

        if (! in_array($column, $this->fillable)) {
            $this->fillable[] = $column;
        }

        return $this;
    }
}
