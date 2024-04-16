<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\ResourceMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\ResourceMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\ResourceMakeCommand\ModelTest
 */
#[CoversClass(ResourceMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_resource_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:resource --force --file %1$s',
            $this->getResourceFile('resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_resource_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:resource --skeleton --force --file %1$s',
            $this->getResourceFile('resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
