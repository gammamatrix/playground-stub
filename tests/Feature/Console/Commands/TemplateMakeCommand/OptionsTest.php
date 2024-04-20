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
 * \Tests\Feature\Playground\Stub\Console\Commands\TemplateMakeCommand\OptionsTest
 */
#[CoversClass(TemplateMakeCommand::class)]
class OptionsTest extends TestCase
{
    public function test_command_with_options(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:template testing --namespace Acme/Testing --package acme-testing --route example --skeleton --force --title Demo --config acme-testing --extends playground::layouts.site --type site --module Acme --model Rocket');
        $result->assertExitCode(0);
    }
}
