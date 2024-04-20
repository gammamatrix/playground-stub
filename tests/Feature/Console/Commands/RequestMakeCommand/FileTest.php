<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\RequestMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\RequestMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\RequestMakeCommand\FileTest
 */
#[CoversClass(RequestMakeCommand::class)]
class FileTest extends TestCase
{
    public function test_command_make_request_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:request --force --file %1$s',
            $this->getResourceFile('request')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_request_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:request --skeleton --force --file %1$s',
            $this->getResourceFile('request')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
