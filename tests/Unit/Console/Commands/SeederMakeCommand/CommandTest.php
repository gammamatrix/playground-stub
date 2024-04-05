<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\FeaUnitture\Playground\Stub\Console\Commands\SeederMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\SeederMakeCommand
 */
#[CoversClass(ServiceProvider::class)]
class CommandTest extends TestCase
{
    public function test_command_displays_help(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('playground:make:seeder --help');
        $result->assertExitCode(0);
    }
}
