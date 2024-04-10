<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\TestMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\TestMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\TestMakeCommand\ModelTest
 */
#[CoversClass(TestMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_test_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:test --force --file %1$s',
            $this->getResourceFile('model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_test_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:test --skeleton --force --file %1$s',
            $this->getResourceFile('model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
