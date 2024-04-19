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
            'playground:make:swagger --force --type model --file %1$s',
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
            'playground:make:swagger --skeleton --force --type model --file %1$s',
            $this->getResourceFile('swagger-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_swagger_model_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:swagger --force --type model --model-file %1$s',
            $this->getResourceFile('model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_swagger_model_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:swagger --skeleton --force --type model --model-file %1$s',
            $this->getResourceFile('model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_swagger_model_without_model_file(): void
    {
        $command = 'playground:make:swagger testing --skeleton --force --type model';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(1);
        $result->expectsOutputToContain('Provide a [--model-file] with a [create] section.');
    }
}
