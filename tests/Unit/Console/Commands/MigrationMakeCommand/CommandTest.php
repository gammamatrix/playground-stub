<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Console\Commands\MigrationMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Console\Commands\MigrationMakeCommand;

/**
 * \Tests\Unit\Playground\Stub\Console\Commands\MigrationMakeCommand
 */
#[CoversClass(MigrationMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_displays_help(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration --help');
        $result->assertExitCode(0);
    }
}
