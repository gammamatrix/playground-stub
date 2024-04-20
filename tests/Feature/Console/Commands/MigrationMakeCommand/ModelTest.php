<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\MigrationMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\MigrationMakeCommand\ModelTest
 */
#[CoversClass(MigrationMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_migration_without_name_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration --force --model-file %1$s',
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(1);
        $result->expectsOutputToContain( __('playground-stub::stub.GeneratorCommand.input.error'));
    }

    public function test_command_make_migration_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration --skeleton --force --file %1$s --model-file %2$s',
            $this->getResourceFile('migration'),
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_create_migration_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration testing --force --create --model-file %1$s',
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_create_migration_without_name_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration --force --create --model-file %1$s',
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(1);
        $result->expectsOutputToContain( __('playground-stub::stub.GeneratorCommand.input.error'));
    }

    public function test_command_make_create_migration_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration testing --skeleton --force --create --file %1$s --model-file %2$s',
            $this->getResourceFile('migration'),
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_update_migration_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration testing --force --update --model-file %1$s',
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_update_migration_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration --skeleton --force --update --file %1$s --model-file %2$s',
            $this->getResourceFile('migration'),
            $this->getResourceFile('model-crm-contact')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_create_migration_and_load_model_from_migration_configuration(): void
    {
        $command = sprintf(
            'playground:make:migration --skeleton --force --create --file %1$s',
            $this->getResourceFile('migration'),
        );
        // $result = $this->withoutMockingConsoleOutput()->artisan($command);
        // dump(Artisan::output());

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_create_migration_with_bare_model_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration Bare --skeleton --force --create --type playground-model --model-file %1$s',
            $this->getResourceFile('playground-model-bare')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_create_migration_with_sparse_model_skeleton(): void
    {
        $command = sprintf(
            'playground:make:migration Sparse --namespace Playground/Testing --skeleton --force --create --type playground-model --model-file %1$s',
            $this->getResourceFile('playground-model-sparse')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
