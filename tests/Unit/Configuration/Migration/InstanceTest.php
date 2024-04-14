<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Migration;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Migration;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Migration\InstanceTest
 */
#[CoversClass(Migration::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Migration;

        $this->assertInstanceOf(Migration::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => '',
        'config' => '',
        'extends' => '',
        'fqdn' => '',
        'extends_use' => '',
        'model' => '',
        'model_fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'table' => '',
        'type' => '',
        'models' => [],
        'uses' => [],
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Migration;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Migration;

        $this->assertInstanceOf(Migration::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_migration_for_model_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('migration');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Migration($options, true);

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-crm', $instance->package());
        $this->assertSame('Crm', $instance->module());
        $this->assertSame('crm', $instance->module_slug());
        $this->assertSame('', $instance->fqdn());
        $this->assertSame('Playground/Crm', $instance->namespace());
        $this->assertSame('2020_01_02_100001_create_crm_contact_table', $instance->name());
        $this->assertSame('', $instance->class());
        $this->assertSame('crm_contacts', $instance->table());
        $this->assertSame('playground-model', $instance->type());
        $this->assertSame([], $instance->uses());
        $this->assertSame([
            'Contact' => 'resources/testing/configurations/test.model.crm.contact.json',
        ], $instance->models());
    }
}
