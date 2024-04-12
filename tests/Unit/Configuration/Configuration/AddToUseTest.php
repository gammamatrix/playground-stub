<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Configuration;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Configuration;
use Playground\Stub\Configuration\Package;
use Playground\Stub\Configuration\Concerns\Classes;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Configuration\AddToUseTest
 */
#[CoversClass(Configuration::class)]
#[CoversClass(Package::class)]
#[CoversClass(Classes::class)]
class AddToUseTest extends TestCase
{
    public function test_addToUse_without_class(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $class = '';
        $key = '';
        $this->assertInstanceOf(Package::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addToUse.class.required', [
            'class' => Package::class,
            'use_class' => $class,
            'key' => '',
        ]));
        $instance->addToUse($class, $key);
    }

    public function test_addToUse_without_key_and_succeed(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $class = '\\Some\\Class\\ToUse';
        $this->assertInstanceOf(Package::class, $instance);

        $this->assertEmpty($instance->uses());
        $instance->addToUse($class);
        $this->assertNotEmpty($instance->uses());
    }

    public function test_addToUse_with_key_and_succeed(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $class = '\\Some\\Class\\ToUse';
        $key = 'SomeKey';
        $this->assertInstanceOf(Package::class, $instance);

        $this->assertEmpty($instance->uses());
        $instance->addToUse($class, $key);
        $this->assertNotEmpty($instance->uses());
    }
}
