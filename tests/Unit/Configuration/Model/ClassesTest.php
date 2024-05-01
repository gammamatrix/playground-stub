<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model;
use Playground\Stub\Configuration\Model\Concerns\Classes;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\ClassesTest
 */
#[CoversClass(Model::class)]
#[CoversClass(Classes::class)]
class ClassesTest extends TestCase
{
    public function test_addExtends_with_string(): void
    {
        $instance = new Model;

        $this->assertInstanceOf(Model::class, $instance);

        $options = [
            'extends' => 'SomeClass',
        ];

        $instance->addExtends($options);

        $this->assertSame('SomeClass', $instance->extends());
    }

    public function test_addImplements_with_string(): void
    {
        $instance = new Model;

        $this->assertInstanceOf(Model::class, $instance);

        $options = [
            'implements' => [
                'Some' => 'OtherClass',
            ],
        ];

        $instance->addImplements($options);
        // dump($instance);

        $this->assertSame($options['implements'], $instance->implements());
    }

    public function test_addModels_with_string(): void
    {
        $instance = new Model;

        $this->assertInstanceOf(Model::class, $instance);

        $options = [
            'models' => [
                'SomeClass' => 'tmp-some-model-configuration.json'
            ],
        ];

        $instance->addModels($options);
        // dump($instance);

        $this->assertSame($options['models'], $instance->models());
    }
}
