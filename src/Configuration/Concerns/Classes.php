<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

/**
 * \Playground\Stub\Configuration\Concerns\Classes
 */
trait Classes
{
    public function addClassTo(
        string $property,
        mixed $fqdn
    ): self {

        if (empty($property)
            || empty($fqdn)
            || ! is_string($fqdn)
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Classes.properties.required', [
                'class' => static::class,
                'property' => $property,
                'fqdn' => is_string($fqdn) ? $fqdn : gettype($fqdn),
            ]));
        }

        if (! property_exists($this, $property)
            || ! is_array($this->{$property})
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Classes.properties.invalid', [
                'class' => static::class,
                'property' => $property,
                'fqdn' => $fqdn,
            ]));
        }

        if (! in_array($fqdn, $this->{$property})) {
            $this->{$property}[] = $fqdn;
        }

        return $this;
    }

    /**
     * @param mixed $value Provide a string value, such as an FQDN or a path to a file.
     */
    public function addMappedClassTo(
        string $property,
        mixed $key,
        mixed $value
    ): self {

        if (empty($property)
            || empty($key)
            || ! is_string($key)
            || empty($value)
            || ! is_string($value)
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Classes.properties.required', [
                'class' => static::class,
                'key' => is_string($key) ? $key : gettype($key),
                'property' => $property,
                'value' => is_string($value) ? $value : gettype($value),
            ]));
        }

        if (! property_exists($this, $property)
            || ! is_array($this->{$property})
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Classes.properties.invalid', [
                'class' => static::class,
                'property' => $property,
                'value' => $value,
            ]));
        }

        $this->{$property}[$key] = $value;

        return $this;
    }

    public function addClassFileTo(
        string $property,
        string $file
    ): self {

        if (empty($property)
            || empty($file)
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Classes.files.required', [
                'class' => static::class,
                'property' => $property,
                'file' => $file,
            ]));
        }

        if (! property_exists($this, $property)
            || ! is_array($this->{$property})
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Classes.properties.invalid', [
                'class' => static::class,
                'property' => $property,
                'file' => $file,
            ]));
        }

        if (! in_array($file, $this->{$property})) {
            $this->{$file}[] = $file;
        }

        return $this;
    }
}
