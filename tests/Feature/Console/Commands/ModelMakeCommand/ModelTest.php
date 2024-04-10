<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\ModelMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand\ModelTest
 */
#[CoversClass(ModelMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_model_with_force(): void
    {
        $command = sprintf(
            'playground:make:model --force --file %1$s',
            $this->getResourceFile('model')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_model_api_with_force(): void
    {
        $command = sprintf(
            'playground:make:model --force --file %1$s',
            $this->getResourceFile('playground-model-api')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_model_resource_with_force(): void
    {
        $command = sprintf(
            'playground:make:model --force --file %1$s',
            $this->getResourceFile('playground-model-resource')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
