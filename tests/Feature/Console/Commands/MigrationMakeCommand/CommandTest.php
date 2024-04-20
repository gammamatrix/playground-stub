<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand;

use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand\CommandTest
 */
class CommandTest extends TestCase
{
    public function test_command_without_options_or_arguments(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration');
        $result->assertExitCode(1);
        $result->expectsOutputToContain( __('playground-stub::stub.GeneratorCommand.input.error'));
    }

    public function test_command_with_reserved_name(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration true');
        $result->assertExitCode(1);
        $result->expectsOutputToContain('The name "true" is reserved by PHP.');
    }

    public function test_command_skeleton(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration testing --skeleton --force');
        $result->assertExitCode(0);
    }

    public function test_command_skeleton_without_force(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration testing --skeleton');
        $result->assertExitCode(1);
        $result->expectsOutputToContain('Migration already exists.');
    }

    public function test_command_skeleton_with_invalid_table_parameter(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:migration testing --skeleton --force --table="invalid ! table name"');
        $result->assertExitCode(0);
        $result->expectsOutputToContain('Invalid table name [invalid ! table name], using argument [testing] to generate.');
    }

    public function test_command_skeleton_with_invalid_table_in_file(): void
    {
        $command = sprintf(
            'playground:make:migration testing --skeleton --force --file %1$s',
            $this->getResourceFile('migration-invalid-table')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
        $result->expectsOutputToContain('Invalid table name [invalid table-name] in configuration, using argument [testing] to generate.');
    }

    public function test_command_skeleton_with_empty_name_in_file(): void
    {
        $command = sprintf(
            'playground:make:migration "   " --skeleton --force --file %1$s',
            $this->getResourceFile('migration-empty-name')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
