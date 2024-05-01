<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\PrimaryConfiguration;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\PrimaryConfiguration;

/**
 * \Tests\Unit\Playground\Stub\Configuration\PrimaryConfiguration\SkeletonTest
 */
#[CoversClass(PrimaryConfiguration::class)]
class SkeletonTest extends TestCase
{
    public function test_skeleton(): void
    {
        $instance = new PrimaryConfiguration;

        $this->assertInstanceOf(PrimaryConfiguration::class, $instance);

        $this->assertFalse($instance->skeleton());
    }

    public function test_skeleton_withSkeleton(): void
    {
        $instance = new PrimaryConfiguration;

        $this->assertFalse($instance->skeleton());

        $instance->withSkeleton();

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_option_as_false(): void
    {
        $options = [
            'skeleton' => false,
        ];

        $instance = new PrimaryConfiguration($options);

        $this->assertFalse($instance->skeleton());
    }

    public function test_skeleton_option_as_true(): void
    {
        $options = [
            'skeleton' => true,
        ];

        $instance = new PrimaryConfiguration($options);

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_parameter_as_true(): void
    {
        $options = [];

        $instance = new PrimaryConfiguration($options, true);

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_parameter_as_false_overrules_option(): void
    {
        $options = [
            'skeleton' => 0,
        ];

        $instance = new PrimaryConfiguration($options, true);

        $this->assertTrue($instance->skeleton());
    }

    public function test_skeleton_parameter_as_true_overrules_option(): void
    {
        $options = [
            'skeleton' => true,
        ];

        $instance = new PrimaryConfiguration($options, false);

        $this->assertFalse($instance->skeleton());

        $instance->withSkeleton();

        $this->assertTrue($instance->skeleton());
    }
}
