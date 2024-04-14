<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\MigrationMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand\ModelTest
 */
#[CoversClass(MigrationMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_factory_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration --force --file %1$s',
            $this->getResourceFile('migration-model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_factory_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration --skeleton --force --file %1$s',
            $this->getResourceFile('migration-model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
