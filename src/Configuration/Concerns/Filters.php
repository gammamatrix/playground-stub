<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\Filters
 */
trait Filters
{
    /**
     * @param array<string, mixed> $options
     */
    public function addModelFilters(array $options): self
    {
        if ( empty($options['filters'])
            || ! is_array($options['filters'])
        ) {
            return $this;
        }

        if (! empty($options['filters']['builder'])
            && is_string($options['filters']['builder'])
        ) {
            foreach ($options['filters']['attributes'] as $attribute => $value) {
                $this->addAttribute($attribute, $value);
            }
        }

        if (! empty($options['filters']['attributes'])
            && is_array($options['filters']['attributes'])
        ) {
            foreach ($options['filters']['attributes'] as $attribute => $value) {
                $this->addAttribute($attribute, $value);
            }
        }

        return $this;
    }

    // public function addAttribute(
    //     mixed $column,
    //     mixed $value
    // ): self {

    //     if (empty($column) || ! is_string($column)) {
    //         throw new \RuntimeException(__('playground-stub::stub.Model.Attributes.invalid', [
    //             'name' => $this->name(),
    //             'column' => is_string($column) ? $column : gettype($column),
    //         ]));
    //     }

    //     if (is_null($value)) {
    //         $this->attributes[$column] = $value;
    //     } elseif (in_array(gettype($value), [
    //         'string',
    //         'integer',
    //         'double',
    //         'boolean',
    //     ])) {
    //         $this->attributes[$column] = $value;
    //     } else {
    //         $this->attributes[$column] = '';
    //     }

    //     return $this;
    // }

    // public function addCast(
    //     mixed $column,
    //     mixed $cast
    // ): self {

    //     if (empty($column) || ! is_string($column)) {
    //         throw new \RuntimeException(__('playground-stub::stub.Model.Attributes.invalid', [
    //             'name' => $this->name(),
    //             'column' => is_string($column) ? $column : gettype($column),
    //         ]));
    //     }

    //     if (!is_string($cast)) {
    //         $this->attributes[$column] = 'string';
    //     } elseif (in_array($cast, [
    //         'datetime',
    //         'dateTime',
    //     ])) {
    //         $this->casts[$column] = 'datetime';
    //     } elseif (in_array($cast, [
    //         'int',
    //         'integer',
    //     ])) {
    //         $this->casts[$column] = 'integer';
    //     } elseif (in_array($cast, [
    //         'bool',
    //         'boolean',
    //     ])) {
    //         $this->casts[$column] = 'boolean';
    //     } elseif(!empty($cast)) {
    //         $this->casts[$column] = $cast;
    //     }

    //     return $this;
    // }

    // public function addFillable(mixed $column): self
    // {
    //     if (empty($column) || ! is_string($column)) {
    //         throw new \RuntimeException(__('playground-stub::stub.Model.Fillable.invalid', [
    //             'name' => $this->name(),
    //             'column' => is_string($column) ? $column : gettype($column),
    //         ]));
    //     }

    //     if (!in_array($column, $this->fillable)) {
    //         $this->fillable[] = $column;
    //     }

    //     return $this;
    // }
}
