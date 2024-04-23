<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model\CreateColumn;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model\CreateColumn;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\CreateColumn\InstanceTest
 */
#[CoversClass(CreateColumn::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new CreateColumn;

        $this->assertInstanceOf(CreateColumn::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'column' => '',
        'label' => '',
        'description' => '',
        'icon' => '',
        'default' => null,
        'index' => false,
        'nullable' => false,
        'readOnly' => false,
        'type' => 'string',
    ];

    public function test_model_with_file_jsonSerialize(): void
    {
        $options = [
            'column' => 'some_column',
        ];
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new CreateColumn($options);

        $instance->apply();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        $this->assertSame('some_column', $instance->column());

        $data = $instance->apply()->jsonSerialize();
        $this->assertIsArray($data);
        $this->assertArrayHasKey('column', $data);
        $this->assertSame('some_column', $data['column']);
    }

    public function test_setOptions_unsupported_primary_and_log_message(): void
    {
        $log = LogFake::bind();

        $instance = new CreateColumn([
            'column' => 'some_column',
            'migration' => 'some_migration_name',
        ]);

        $this->assertInstanceOf(CreateColumn::class, $instance);

        // dump($instance);
        $instance->setOptions([
            'type' => 'some-custom-type',
        ]);

        // $log->dump();

        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'warning'
        );

        $allowed_types = [
            'uuid',
            'ulid',
            'string',
            'smallText',
            'mediumText',
            'text',
            'longText',
            'boolean',
            'integer',
            'bigInteger',
            'mediumInteger',
            'smallInteger',
            'tinyInteger',
            'dateTime',
            'decimal',
            'float',
            'double',
        ];

        $log->assertLogged(
            fn (LogEntry $log) => is_string($log->message) && str_contains(
                $log->message,
                __('playground-stub::stub.Model.CreateColumn.type.unexpected', [
                    'column' => 'some_column',
                    'type' => 'some-custom-type',
                    'allowed' => implode(', ', $allowed_types),
                ])
            )
        );
    }
}