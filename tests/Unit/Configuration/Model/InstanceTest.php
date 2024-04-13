<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\InstanceTest
 */
#[CoversClass(Model::class)]
#[CoversClass(Model\Create::class)]
#[CoversClass(Model\CreateColumn::class)]
#[CoversClass(Model\CreateDate::class)]
#[CoversClass(Model\CreateFlag::class)]
#[CoversClass(Model\CreateDate::class)]
#[CoversClass(Model\CreateId::class)]
#[CoversClass(Model\CreateJson::class)]
#[CoversClass(Model\CreatePermission::class)]
#[CoversClass(Model\CreateStatus::class)]
#[CoversClass(Model\CreateUi::class)]
#[CoversClass(Model\CreateUnique::class)]
#[CoversClass(Model\Filters::class)]
#[CoversClass(Model\HasMany::class)]
#[CoversClass(Model\HasOne::class)]
#[CoversClass(Model\ModelConfiguration::class)]
#[CoversClass(Model\Sortable::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Model;

        $this->assertInstanceOf(Model::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'model' => '',
        'type' => '',
        'table' => '',
        'factory' => false,
        'migration' => false,
        'policy' => false,
        'seed' => false,
        'test' => false,
        // "organization": "GammaMatrix",
        // "package": "playground-matrix",
        // "module": "Matrix",
        // "module_slug": "matrix",
        // "fqdn": "GammaMatrix/Playground/Matrix/Models/Backlog",
        // "namespace": "GammaMatrix/Playground/Matrix",
        // "name": "Backlog",
        // "class": "Backlog",
        // "model": "GammaMatrix/Playground/Matrix/Models/Backlog",
        // "type": "playground-resource",
        // "table": "matrix_backlogs",
        // "extends": "AbstractModel",
        // "implements": [],
        'extends' => '',
        'implements' => [],
        'HasOne' => [],
        'HasMany' => [],
        'scopes' => [],
        'attributes' => [],
        'casts' => [],
        'fillable' => [],
        'filters' => null,
        'models' => [],
        'sortable' => [],
        'create' => null,
        'uses' => [],
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Model;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Model;

        $this->assertInstanceOf(Model::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_model_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('model-backlog');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Model($options, true);

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
        $this->assertSame('playground-matrix', $instance->package());
        $this->assertSame('Matrix', $instance->module());
        $this->assertSame('matrix', $instance->module_slug());
        $this->assertSame('Playground/Matrix/Models/Backlog', $instance->fqdn());
        $this->assertSame('Playground/Matrix', $instance->namespace());
        $this->assertSame('Playground/Matrix/Models/Backlog', $instance->model());
        $this->assertSame('Backlog', $instance->name());
        $this->assertSame('Backlog', $instance->class());
        $this->assertSame('playground-model', $instance->type());
        $this->assertSame('matrix_backlogs', $instance->table());
        $this->assertSame('AbstractModel', $instance->extends());
        $this->assertSame([], $instance->implements());
        $this->assertFalse($instance->factory());
        $this->assertFalse($instance->migration());
        $this->assertFalse($instance->policy());
        $this->assertFalse($instance->seed());
        $this->assertFalse($instance->test());
    }
}
