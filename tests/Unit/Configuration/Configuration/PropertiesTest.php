<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Configuration;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Configuration;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Configuration\PropertiesTest
 */
#[CoversClass(Configuration::class)]
class PropertiesTest extends TestCase
{
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
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'type' => '',
        'uses' => [],
    ];

    public function test_properties(): void
    {
        $instance = new Configuration;

        $this->assertInstanceOf(Configuration::class, $instance);

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_properties_with_all_options_without_apply(): void
    {
        $options = [
            'class' => 'SomeClassRequest',
            'config' => 'some-package',
            'extends' => 'SomeExtendedClass',
            'fqdn' => 'Acme\\SomeClass',
            'extends_use' => 'Illuminate/Foundation/Http/FormRequest',
            'model' => 'Something',
            'module' => 'Some',
            'module_slug' => 'some',
            'name' => 'Some',
            'namespace' => 'Acme',
            'organization' => 'Acme',
            'package' => 'some-package',
            'type' => 'request',
            'uses' => [
                'ImportantClass' => 'Acme\\ImportantClass',
                'Acme/AnotherImportantClass',
            ],
        ];

        $instance = new Configuration($options, true);
        // dump($instance);

        $this->assertTrue($instance->skeleton());

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($this->expected_properties, $jsonSerialize);

        $this->assertSame($options['class'], $instance->class());
        $this->assertSame($options['config'], $instance->config());
        $this->assertSame($options['fqdn'], $instance->fqdn());
        $this->assertSame($options['model'], $instance->model());
        $this->assertSame($options['module'], $instance->module());
        $this->assertSame($options['module_slug'], $instance->module_slug());
        $this->assertSame($options['name'], $instance->name());
        $this->assertSame($options['namespace'], $instance->namespace());
        $this->assertSame($options['organization'], $instance->organization());
        $this->assertSame($options['package'], $instance->package());
        $this->assertSame($options['type'], $instance->type());
        $this->assertSame($options['uses'], $instance->uses());
        $this->assertSame($options['extends'], $instance->extends());
        $this->assertSame($options['extends_use'], $instance->extends_use());
    }

    public function test_properties_with_all_options_with_apply(): void
    {
        $options = [
            'class' => 'SomeClassRequest',
            'config' => 'some-package',
            'extends' => 'SomeExtendedClass',
            'fqdn' => 'Acme\\SomeClass',
            'extends_use' => 'Illuminate/Foundation/Http/FormRequest',
            'model' => 'Something',
            'module' => 'Some',
            'module_slug' => 'some',
            'name' => 'Some',
            'namespace' => 'Acme',
            'organization' => 'Acme',
            'package' => 'some-package',
            'type' => 'request',
            'uses' => [
                'ImportantClass' => 'Acme\\ImportantClass',
                'Acme/AnotherImportantClass',
            ],
        ];

        $instance = new Configuration($options, true);
        $instance->apply();

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertNotSame($this->expected_properties, $jsonSerialize);

        $this->assertTrue($instance->skeleton());

        $this->assertSame($options['class'], $instance->class());
        $this->assertSame($options['config'], $instance->config());
        $this->assertSame($options['fqdn'], $instance->fqdn());
        $this->assertSame($options['model'], $instance->model());
        $this->assertSame($options['module'], $instance->module());
        $this->assertSame($options['module_slug'], $instance->module_slug());
        $this->assertSame($options['name'], $instance->name());
        $this->assertSame($options['namespace'], $instance->namespace());
        $this->assertSame($options['organization'], $instance->organization());
        $this->assertSame($options['package'], $instance->package());
        $this->assertSame($options['type'], $instance->type());
        $this->assertSame($options['uses'], $instance->uses());
        $this->assertSame($options['extends'], $instance->extends());
        $this->assertSame($options['extends_use'], $instance->extends_use());

        $this->assertSame($options, $jsonSerialize);
    }
}
