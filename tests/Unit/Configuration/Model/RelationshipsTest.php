<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Model;
use Playground\Stub\Configuration\Model\Concerns\Relationships;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Model\RelationshipsTest
 */
#[CoversClass(Model::class)]
#[CoversClass(Relationships::class)]
class RelationshipsTest extends TestCase
{
    public function test_addRelationships_for_HasOne_with_invalid_accessor(): void
    {
        $instance = new Model([
            'name' => 'SomeModel',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $options = [
            'HasOne' => [
                'ownedBy' => [

                ],
                2 => 'HasOne',
            ],
        ];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.HasOne.invalid', [
            'name' => 'SomeModel',
            'accessor' => 'integer',
        ]));

        $instance->addRelationships($options);
    }

    public function test_addRelationships_for_HasMany_with_invalid_accessor(): void
    {
        $instance = new Model([
            'name' => 'SomeModel',
        ]);

        $this->assertInstanceOf(Model::class, $instance);

        $options = [
            'HasMany' => [
                'ownedBy' => [
                    'comment' => 'comment',
                    'related' => 'related',
                    'foreignKey' => 'foreignKey',
                    'localKey' => 'localKey',
                ],
                'HasMany',
            ],
        ];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(__('playground-stub::stub.Model.HasMany.invalid', [
            'name' => 'SomeModel',
            'accessor' => 'integer',
        ]));

        $instance->addRelationships($options);
    }
}
