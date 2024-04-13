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
 * \Tests\Feature\Playground\Stub\Console\Commands\ModelMakeCommand\OptionsTest
 */
#[CoversClass(ModelMakeCommand::class)]
class OptionsTest extends TestCase
{
    public function test_command_make_model_with_all_of_the_option_flags(): void
    {
        $command = 'playground:make:model testing --force --controller --factory --migration --policy --requests --seed --test';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_pivot_type(): void
    {
        $command = 'playground:make:model testing --force --type pivot';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_pivot_option(): void
    {
        $command = 'playground:make:model testing --force --pivot';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_morph_pivot_type(): void
    {
        $command = 'playground:make:model testing --force --type morph-pivot';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_morph_pivot_option(): void
    {
        $command = 'playground:make:model testing --force --morph-pivot';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_api_type(): void
    {
        $command = 'playground:make:model testing --force --type api';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_abstract_type(): void
    {
        $command = 'playground:make:model testing --force --type abstract';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_model_with_model_type(): void
    {
        $command = 'playground:make:model testing --force --type model';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
