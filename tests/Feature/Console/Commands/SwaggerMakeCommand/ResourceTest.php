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
 * \Tests\Feature\Playground\Stub\Console\Commands\SwaggerMakeCommand\ResourceTest
 */
#[CoversClass(SwaggerMakeCommand::class)]
class ResourceTest extends TestCase
{
    public function test_command_make_swagger_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:swagger --force --file %1$s',
            $this->getResourceFile('swagger-resource')
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
            'playground:make:swagger --skeleton --force --controller-type playground-resource --file %1$s',
            $this->getResourceFile('swagger-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}