<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\ControllerMakeCommand;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\Command;
use Playground\Stub\Console\Commands\ControllerMakeCommand;
use Playground\Stub\Console\Commands\GeneratorCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\ControllerMakeCommand
 */
#[CoversClass(Command::class)]
#[CoversClass(GeneratorCommand::class)]
#[CoversClass(ControllerMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:controller');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton(): void
    {
        // $result = $this->withoutMockingConsoleOutput()->artisan('playground:make:controller testing --skeleton --force');
        // dd(Artisan::output());
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:controller testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
