<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\ModelMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand\ConfigurationTest
 */
#[CoversClass(ModelMakeCommand::class)]
class ConfigurationTest extends TestCase
{
    public function test_command_with_file_skeleton_and_force(): void
    {
        $file = sprintf(
            '%1$s/resources/testing/configurations/model.backlog.json',
            dirname(dirname(dirname(dirname(dirname(__DIR__)))))
        );

        $command = 'playground:make:model --skeleton --force --file '.$file;
        // $result = $this->withoutMockingConsoleOutput()->artisan($command);
        // dd(Artisan::output());
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
