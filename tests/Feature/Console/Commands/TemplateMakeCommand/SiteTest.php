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
 * \Tests\Feature\Playground\Stub\Console\Commands\TemplateMakeCommand\SiteTest
 */
#[CoversClass(TemplateMakeCommand::class)]
class SiteTest extends TestCase
{
    public function test_command_make_site_template_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --force --type site --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_site_template_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --skeleton --force --type site --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_site_template_with_force_and_without_skeleton_without_file(): void
    {
        $command = 'playground:make:template testing --force --type site';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_site_template_with_force_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:template testing --skeleton --force --type site';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_template_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --force --type playground --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_template_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:template --skeleton --force --type playground --file %1$s',
            $this->getResourceFile('template')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_template_with_force_and_without_skeleton_without_file(): void
    {
        $command = 'playground:make:template testing --force --type playground';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_playground_template_with_force_and_with_skeleton_without_file(): void
    {
        $command = 'playground:make:template testing --skeleton --force --type playground';

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
