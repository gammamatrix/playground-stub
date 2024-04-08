<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\SeederMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\SeederMakeCommand;
use Tests\Unit\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\SeederMakeCommand
 */
#[CoversClass(SeederMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:seeder testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
