<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\Command;
use Playground\Stub\Console\Commands\GeneratorCommand;
use Playground\Stub\Console\Commands\ModelMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand
 */
#[CoversClass(Command::class)]
#[CoversClass(GeneratorCommand::class)]
#[CoversClass(ModelMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:model');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:model testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
