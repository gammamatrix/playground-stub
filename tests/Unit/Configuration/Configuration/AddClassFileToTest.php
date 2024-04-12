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
 * \Tests\Unit\Playground\Stub\Configuration\Configuration\AddClassFileToTest
 */
#[CoversClass(Configuration::class)]
#[CoversClass(Package::class)]
#[CoversClass(Classes::class)]
class AddClassFileToTest extends TestCase
{
    public function test_addClassFileTo_without_property(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $property = '';
        $file = '';
        $this->assertInstanceOf(Package::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addClassFileTo.property.required', [
            'class' => Package::class,
            'property' => $property,
            'file' => $file,
        ]));
        $instance->addClassFileTo($property, $file);
    }

    public function test_addClassFileTo_without_file(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $property = 'models';
        $file = '';
        $this->assertInstanceOf(Package::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addClassFileTo.file.required', [
            'class' => Package::class,
            'property' => $property,
            'file' => $file,
        ]));
        $instance->addClassFileTo($property, $file);
    }

    public function test_addClassFileTo_with_missing_property(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $property = 'somePropertyThatDoesNotExist';
        $file = 'tmp-some-configuration-file.json';
        $this->assertInstanceOf(Package::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Configuration.addClassFileTo.property.missing', [
            'class' => Package::class,
            'property' => $property,
            'file' => $file,
        ]));
        $instance->addClassFileTo($property, $file);
    }

    public function test_addClassFileTo_with_valid_parameters_and_succeed(): void
    {
        $withSkeleton = true;
        $instance = new Package([
            'name' => 'SomePackage',
        ], $withSkeleton);

        $property = 'models';
        $file = 'tmp-some-configuration-file.json';
        $this->assertInstanceOf(Package::class, $instance);

        $this->assertEmpty($instance->models());
        $instance->addClassFileTo($property, $file);
        $this->assertNotEmpty($instance->models());
    }
}
