<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model;
use Playground\Stub\Configuration\Model\Concerns\Attributes;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\AttributesTest
 */
#[CoversClass(Model::class)]
#[CoversClass(Attributes::class)]
class AttributesTest extends TestCase
{
    public function test_addModelProperties_with_empty_options(): void
    {
        $instance = new Model;

        $this->assertInstanceOf(Model::class, $instance);

        $options = [];

        $instance->addModelProperties($options);

        $this->assertEmpty($instance->attributes());
        $this->assertEmpty($instance->casts());
        $this->assertEmpty($instance->fillable());
    }

    public function test_addAttribute_with_invalid_column(): void
    {
        $instance = new Model([
            // 'name' => 'model',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $column = null;
        $value = false;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Attributes.invalid', [
            'name' => 'model',
            'column' => 'NULL',
        ]));

        $instance->addAttribute($column, $value);
    }

    public function test_addAttribute_with_invalid_default_value_of_array(): void
    {
        $instance = new Model([
            // 'name' => 'model',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $column = 'some_column';
        $value = ['arrays-are-not-allowed'];

        $instance->addAttribute($column, $value);

        $attributes = $instance->attributes();
        $this->assertArrayHasKey($column, $attributes);
        $this->assertEmpty($attributes[$column]);
    }

    public function test_addCast_with_invalid_column_and_set_empty_string(): void
    {
        $instance = new Model([
            'name' => 'Widget',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $column = true;
        $value = false;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Casts.invalid', [
            'name' => 'Widget',
            'column' => 'boolean',
        ]));

        $instance->addCast($column, $value);
    }

    public function test_addCast_with_invalid_cast_value_and_treat_as_string(): void
    {
        $instance = new Model([
            'name' => 'Widget',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $column = 'some_column';
        $value = false;

        $instance->addCast($column, $value);
        $casts = $instance->casts();
        $this->assertArrayHasKey($column, $casts);
        $this->assertSame('string', $casts[$column]);
    }

    public function test_addFillable_with_invalid_column(): void
    {
        $instance = new Model([
            'name' => 'Thing',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $column = ['invalid-stuff'];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Fillable.invalid', [
            'name' => 'Thing',
            'column' => 'array',
        ]));

        $instance->addFillable($column);
    }
}
