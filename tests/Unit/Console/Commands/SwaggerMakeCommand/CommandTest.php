<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Console\Commands\SwaggerMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Console\Commands\SwaggerMakeCommand;

/**
 * \Tests\Unit\Playground\Stub\Console\Commands\SwaggerMakeCommand
 */
#[CoversClass(SwaggerMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_displays_help(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:swagger --help');
        $result->assertExitCode(0);
    }
}
