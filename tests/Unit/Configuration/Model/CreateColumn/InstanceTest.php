<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model\Create;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model\Create;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\Create\InstanceTest
 */
#[CoversClass(Create::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'migration' => '',
        'primary' => '',
        'timestamps' => false,
        'softDeletes' => false,
        'trash' => [],
        'ids' => [],
        'unique' => [],
        'dates' => [],
        'flags' => [],
        'columns' => [],
        'permissions' => [],
        'status' => [],
        'ui' => [],
        'json' => [],
    ];

    public function test_model_with_file(): void
    {
        $options = $this->getResourceFileAsArray('model-backlog');

        $instance = new Create($options['create'] ?? []);

        $instance->apply();

        $this->assertSame('uuid', $instance->primary());
    }

    public function test_setOptions_unsupported_primary_and_ignore(): void
    {
        $log = LogFake::bind();

        $instance = new Create([
            'migration' => 'some_migration_name',
        ]);

        $this->assertInstanceOf(Create::class, $instance);

        // dump($instance);
        $instance->setOptions([
            'primary' => 'some-custom-type',
        ]);

        // $log->dump();

        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-stub::stub.Model.Create.primary.unexpected', [
                    'primary' => 'some-custom-type',
                    'allowed' => 'string, uuid, increments',
                ])
            )
        );
    }

    public function test_addId_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.id.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addId($column, $meta);
    }

    public function test_addUnique_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.unique.invalid', [
            'i' => '',
        ]));

        $i = 0;
        $meta = '';
        $instance->addUnique($i, $meta);
    }

    public function test_addDate_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.date.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addDate($column, $meta);
    }

    public function test_addFlag_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.flag.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addFlag($column, $meta);
    }

    public function test_addColumn_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.column.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addColumn($column, $meta);
    }

    public function test_addPermission_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.permission.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addPermission($column, $meta);
    }

    public function test_addStatus_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.status.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addStatus($column, $meta);
    }

    public function test_addUi_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.ui.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addUi($column, $meta);
    }

    public function test_addJson_with_empty_column(): void
    {
        $instance = new Create;

        $this->assertInstanceOf(Create::class, $instance);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.Create.json.invalid', [
            'column' => '',
        ]));

        $column = '';
        $meta = '';
        $instance->addJson($column, $meta);
    }
}
