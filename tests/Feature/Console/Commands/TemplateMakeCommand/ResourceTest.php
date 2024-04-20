<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\TemplateMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\TemplateMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\TemplateMakeCommand\ResourceTest
 */
#[CoversClass(TemplateMakeCommand::class)]
class ResourceTest extends TestCase
{
    public function test_command_make_playground_resource_template_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --force --type playground-resource --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_template_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --skeleton --force --type playground-resource --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_template_with_force_and_without_skeleton_without_file(): void
    {
        $command = 'playground:make:template --force --type playground-resource';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_template_with_force_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:template --skeleton --force --type playground-resource';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_index_template_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --force --type playground-resource-index --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_index_template_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --skeleton --force --type playground-resource-index --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_index_template_with_force_and_without_skeleton_without_file(): void
    {
        $command = 'playground:make:template --force --type playground-resource-index';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_resource_index_template_with_force_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:template --skeleton --force --type playground-resource-index';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
