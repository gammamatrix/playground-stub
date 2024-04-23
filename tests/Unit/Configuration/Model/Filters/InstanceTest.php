<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model\Filters;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\InstanceTest
 */
#[CoversClass(Model\Filter::class)]
#[CoversClass(Model\Filters::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'builder' => null,
        'ids' => [],
        'dates' => [],
        'flags' => [],
        'trash' => [
            'hide' => true,
            'only' => true,
            'with' => true,
        ],
        'columns' => [],
        'permissions' => [],
        'status' => [],
        'ui' => [],
        'json' => [],
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Model\Filters;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_model_with_file(): void
    {
        $options = $this->getResourceFileAsArray('model-backlog');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Model\Filters($options['filters'] ?? []);

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        $this->assertNotEmpty($instance->ids());
        $this->assertNotEmpty($instance->dates());
        $this->assertNotEmpty($instance->flags());
        $this->assertNotEmpty($instance->columns());
    }

    public function test_setOptions_with_builder_in_options(): void
    {
        $instance = new Model\Filters([
            'builder' => 'SomeBuilder',
        ]);

        $this->assertSame('SomeBuilder', $instance->builder());
    }

    public function test_addId_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Id.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addId($i, $meta);
    }

    public function test_addDate_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Date.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addDate($i, $meta);
    }

    public function test_addFlag_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Flag.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addFlag($i, $meta);
    }

    public function test_handleTrash_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Trash.invalid'));

        $meta = '';
        $instance->handleTrash($meta);
    }

    public function test_addColumn_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Column.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addColumn($i, $meta);
    }

    public function test_addPermission_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Permission.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addPermission($i, $meta);
    }

    public function test_addStatus_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Status.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addStatus($i, $meta);
    }

    public function test_addUi_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Ui.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addUi($i, $meta);
    }

    public function test_addJson_with_empty_meta(): void
    {
        $instance = new Model\Filters;

        $this->assertInstanceOf(Model\Filters::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Filters.Json.invalid', [
            'i' => 0,
        ]));

        $i = 0;
        $meta = '';
        $instance->addJson($i, $meta);
    }
}
