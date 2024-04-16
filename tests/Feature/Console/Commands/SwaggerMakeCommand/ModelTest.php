<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\SwaggerMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\SwaggerMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\SwaggerMakeCommand\ModelTest
 */
#[CoversClass(SwaggerMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_swagger_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:swagger --force --file %1$s',
            $this->getResourceFile('swagger-model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_swagger_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:swagger --skeleton --force --file %1$s',
            $this->getResourceFile('swagger-model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
