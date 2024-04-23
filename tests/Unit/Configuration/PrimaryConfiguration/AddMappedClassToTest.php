<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\PrimaryConfiguration;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\PrimaryConfiguration;
use Playground\Stub\Configuration\Test;
use Playground\Stub\Configuration\Concerns\Classes;

/**
 * \Tests\Unit\Playground\Stub\Configuration\PrimaryConfiguration\AddMappedClassToTest
 */
#[CoversClass(PrimaryConfiguration::class)]
#[CoversClass(Test::class)]
#[CoversClass(Classes::class)]
class AddMappedClassToTest extends TestCase
{
    public function test_addMappedClassTo_without_property(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = '';
        $key = NULL;
        $value = NULL;
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addMappedClassTo.property.required', [
            'class' => Test::class,
            'property' => $property,
            'key' => 'NULL',
            'value' => 'NULL',
        ]));
        $instance->addMappedClassTo($property, $key, $value);
    }

    public function test_addMappedClassTo_without_key(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'models';
        $key = NULL;
        $value = NULL;
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addMappedClassTo.key.required', [
            'class' => Test::class,
            'property' => $property,
            'key' => 'NULL',
            'value' => 'NULL',
        ]));
        $instance->addMappedClassTo($property, $key, $value);
    }

    public function test_addMappedClassTo_without_value(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'models';
        $key = 'SomeModel';
        $value = NULL;
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addMappedClassTo.value.required', [
            'class' => Test::class,
            'property' => $property,
            'key' => $key,
            'value' => 'NULL',
        ]));
        $instance->addMappedClassTo($property, $key, $value);
    }

    public function test_addMappedClassTo_with_missing_property(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'someInvalidProperty';
        $key = 'SomeModel';
        $value = '\\Some\\ClassName';
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addMappedClassTo.property.missing', [
            'class' => Test::class,
            'property' => $property,
            'key' => $key,
            'value' => $value,
        ]));
        $instance->addMappedClassTo($property, $key, $value);
    }

    public function test_addMappedClassTo_with_valid_parameters_and_succeed(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'models';
        $key = 'SomeModel';
        $value = '\\Some\\ClassName';
        $this->assertInstanceOf(Test::class, $instance);

        $this->assertEmpty($instance->models());
        $instance->addMappedClassTo($property, $key, $value);
        $this->assertNotEmpty($instance->models());
    }
}