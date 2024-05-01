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
 * \Tests\Unit\Playground\Stub\Configuration\PrimaryConfiguration\AddClassToTest
 */
#[CoversClass(PrimaryConfiguration::class)]
#[CoversClass(Test::class)]
#[CoversClass(Classes::class)]
class AddClassToTest extends TestCase
{
    public function test_addClassTo_without_property(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        // $property = 'somePropertyThatDoesNotExist';
        $property = '';
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.PrimaryConfiguration.addClassTo.property.required', [
            'class' => Test::class,
            'property' => $property,
            'fqdn' => 'NULL',
        ]));
        $instance->addClassTo($property, null);
    }

    public function test_addClassTo_without_fqdn(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'models';
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.PrimaryConfiguration.addClassTo.fqdn.required', [
            'class' => Test::class,
            'property' => $property,
            'fqdn' => 'NULL',
        ]));
        $instance->addClassTo($property, null);
    }

    public function test_addClassTo_with_missing_property(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'somePropertyThatDoesNotExist';
        $fqdn = '\\Some\\Fqdn';
        $this->assertInstanceOf(Test::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.PrimaryConfiguration.addClassTo.property.missing', [
            'class' => Test::class,
            'property' => $property,
            'fqdn' => $fqdn,
        ]));
        $instance->addClassTo($property, $fqdn);
    }

    public function test_addClassTo_with_valid_parameters_and_succeed(): void
    {
        $withSkeleton = true;
        $instance = new Test([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $property = 'models';
        $fqdn = '\\Some\\Fqdn';
        $this->assertInstanceOf(Test::class, $instance);

        $this->assertEmpty($instance->models());
        $instance->addClassTo($property, $fqdn);
        $this->assertNotEmpty($instance->models());
    }
}
