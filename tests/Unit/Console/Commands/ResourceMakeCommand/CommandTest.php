<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Console\Commands\ResourceMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Console\Commands\ResourceMakeCommand;

/**
 * \Tests\Unit\Playground\Stub\Console\Commands\ResourceMakeCommand
 */
#[CoversClass(ResourceMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_displays_help(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:resource --help');
        $result->assertExitCode(0);
    }
}
