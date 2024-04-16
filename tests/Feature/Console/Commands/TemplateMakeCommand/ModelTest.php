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
 * \Tests\Feature\Playground\Stub\Console\Commands\TemplateMakeCommand\ModelTest
 */
#[CoversClass(TemplateMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_template_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --force --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_template_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --skeleton --force --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
