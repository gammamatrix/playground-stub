<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model;
use Playground\Stub\Configuration\Model\Concerns\Sorting;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\SortingTest
 */
#[CoversClass(Model::class)]
#[CoversClass(Sorting::class)]
class SortingTest extends TestCase
{
    public function test_addSortable_without_column(): void
    {
        $withSkeleton = true;
        $instance = new Model([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $this->assertInstanceOf(Model::class, $instance);

        $this->assertEmpty($instance->scopes());

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Sorting.invalid', [
            'name' => 'SomeModel',
            'i' => '-',
        ]));
        $instance->addSortable(null, null);
    }

    public function test_addSortable_with_index(): void
    {
        $withSkeleton = true;
        $instance = new Model([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $this->assertInstanceOf(Model::class, $instance);

        $this->assertEmpty($instance->sortable());
        $instance->addSortable([
            'column' => 'some_column',
        ], 1);
        // dump($instance);
        $this->assertNotEmpty($instance->sortable());
    }

    public function test_addSortable_without_index(): void
    {
        $withSkeleton = true;
        $instance = new Model([
            'name' => 'SomeModel',
        ], $withSkeleton);

        $this->assertInstanceOf(Model::class, $instance);

        $this->assertEmpty($instance->sortable());
        $instance->addSortable([
            'column' => 'some_column',
        ]);
        // dump($instance);
        $this->assertNotEmpty($instance->sortable());
    }
}
