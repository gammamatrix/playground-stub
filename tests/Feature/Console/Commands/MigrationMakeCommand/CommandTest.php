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
 * \Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand
 */
#[CoversClass(MigrationMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
