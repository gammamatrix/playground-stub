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
 * \Tests\Unit\Playground\Stub\Configuration\Configuration\SkeletonTest
 */
#[CoversClass(Configuration::class)]
class SkeletonTest extends TestCase
{
    public function test_skeleton(): void
    {
        $instance = new Configuration;

        $this->assertInstanceOf(Configuration::class, $instance);

        $this->assertFalse($instance->skeleton());
    }

    public function test_skeleton_withSkeleton(): void
    {
        $instance = new Configuration;

        $this->assertFalse($instance->skeleton());

        $instance->withSkeleton();

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_option_as_false(): void
    {
        $options = [
            'skeleton' => false,
        ];

        $instance = new Configuration($options);

        $this->assertFalse($instance->skeleton());
    }

    public function test_skeleton_option_as_true(): void
    {
        $options = [
            'skeleton' => true,
        ];

        $instance = new Configuration($options);

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_parameter_as_true(): void
    {
        $options = [];

        $instance = new Configuration($options, true);

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_parameter_as_false_overrules_option(): void
    {
        $options = [
            'skeleton' => 0,
        ];

        $instance = new Configuration($options, true);

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_parameter_as_true_overrules_option(): void
    {
        $options = [
            'skeleton' => true,
        ];

        $instance = new Configuration($options, false);

        $this->assertFalse($instance->skeleton());

        $instance->withSkeleton();

        $this->assertTrue($instance->skeleton());
    }
}
