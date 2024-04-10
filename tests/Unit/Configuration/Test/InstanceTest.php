<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Test;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Test;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Test\InstanceTest
 */
#[CoversClass(Test::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Test;

        $this->assertInstanceOf(Test::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'model' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'type' => '',
        'uses' => [],
        // properties
        'extends' => '\Tests\TestCase',
        'model_fqdn' => '',
        'models' => [],
        'suite' => '',
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Test;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Test;

        $this->assertInstanceOf(Test::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_test_with_file_and_skeleton(): void
    {
        $file = $this->getResourceFile('test-model');
        $content = file_exists($file) ? file_get_contents($file) : null;
        $options = $content ? json_decode($content, true) : [];
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Test(
            is_array($options) ? $options : [],
            true
        );

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
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
        $this->assertSame('Playground/Crm/Models/Contact', $instance->model_fqdn());
        $this->assertSame('Contact', $instance->model());
        $this->assertSame('Contact', $instance->name());
        $this->assertSame('ModelTest', $instance->class());
        $this->assertSame('playground-model', $instance->type());
        $this->assertSame('Playground/Crm/Models/Contact', $instance->model_fqdn());
        $this->assertSame([
            'Contact' => 'tmp-testing-model.crm.contact.json',
        ], $instance->models());
        $this->assertSame('ModelCase', $instance->extends());
    }
}
