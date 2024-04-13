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
 * \Tests\Unit\Playground\Stub\Configuration\Model\InstanceTest
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

    public function test_model_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('model-backlog');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Create($options['create'] ?? [], true);

        $instance->apply();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        $this->assertTrue($instance->skeleton());

        $this->assertSame('uuid', $instance->primary());
    }

    public function test_setOptions_unsupported_primary_and_ignore(): void
    {
        $log = LogFake::bind();

        $withSkeleton = true;
        $instance = new Create([
            'migration' => 'some_migration_name',
        ], $withSkeleton);

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
}
