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
 * \Tests\Feature\Playground\Stub\Console\Commands\ControllerMakeCommand\FileTest
 */
#[CoversClass(Command::class)]
#[CoversClass(GeneratorCommand::class)]
#[CoversClass(ControllerMakeCommand::class)]
class FileTest extends TestCase
{
    public function test_command_make_controller_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:controller --force --file %1$s',
            $this->getResourceFile('controller-playground-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_controller_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:controller --skeleton --force --file "%1$s"',
            $this->getResourceFile('controller-playground-resource')
        );
        // dump($command);
        // $result = $this->withoutMockingConsoleOutput()->artisan('playground:make:controller testing --skeleton --force');
        // dump(Artisan::output());

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
