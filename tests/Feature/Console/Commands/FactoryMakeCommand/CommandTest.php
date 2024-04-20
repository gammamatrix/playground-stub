<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\FactoryMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\FactoryMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\FactoryMakeCommand
 */
#[CoversClass(FactoryMakeCommand::class)]
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:factory');
        $result->assertExitCode(1);
        $result->expectsOutputToContain( __('playground-stub::stub.GeneratorCommand.input.error'));
    }

    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:factory testing --skeleton --force');
        $result->assertExitCode(0);
    }
}
