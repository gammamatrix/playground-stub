<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Acceptance\Playground\Stub\Console\Commands\PackageMakeCommand;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Stub\Console\Commands\PackageMakeCommand;
use Tests\Feature\Playground\Stub\TestCase;

/**
 * \Tests\Feature\Playground\Stub\Console\Commands\PackageMakeCommand\ModelTest
 */
#[CoversClass(PackageMakeCommand::class)]
class ModelTest extends TestCase
{
    public function test_command_make_api_package_with_force_and_without_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --force --file %1$s',
            $this->getResourceFile('test-package-api')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }

    public function test_command_make_api_package_with_force_and_with_skeleton(): void
    {
        $command = sprintf(
            'playground:make:package --skeleton --force --file %1$s',
            $this->getResourceFile('test-package-api')
        );

        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan($command);
        $result->assertExitCode(0);
    }
}
