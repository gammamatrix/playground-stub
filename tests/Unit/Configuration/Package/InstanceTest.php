<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub\Configuration\Package;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\Playground\Stub\TestCase;
use Playground\Stub\Configuration\Package;

/**
 * \Tests\Unit\Playground\Stub\Configuration\Package\InstanceTest
 */
#[CoversClass(Package::class)]
class InstanceTest extends TestCase
{
    public function test_instance(): void
    {
        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);
    }

    /**
     * @var array<string, mixed>
     */
    protected array $expected_properties = [
        'class' => 'ServiceProvider',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'factories' => false,
        'package_name' => '',
        'package_autoload' => '',
        'package_description' => '',
        'package_homepage' => '',
        'package_keywords' => [],
        'package_license' => '',
        'package_require' => [],
        'package_require_dev' => [],
        'package_autoload_psr4' => [],
        'package_laravel_providers' => [],
        'packagist' => '',
        'controllers' => [],
        'models' => [],
        'policies' => [],
        'routes' => [],
        'service_provider' => '',
        // 'version' => '0.1.2-alpha.3',
        'version' => '',
    ];

    public function test_instance_apply_without_options(): void
    {
        $instance = new Package;

        $properties = $instance->apply()->properties();

        $this->assertIsArray($properties);

        $this->assertSame($this->expected_properties, $properties);

        $jsonSerialize = $instance->jsonSerialize();

        $this->assertIsArray($jsonSerialize);

        $this->assertSame($properties, $jsonSerialize);
    }

    public function test_folder_is_empty_by_default(): void
    {
        $instance = new Package;

        $this->assertInstanceOf(Package::class, $instance);

        $this->assertIsString($instance->folder());
        $this->assertEmpty($instance->folder());
    }

    public function test_package_for_model_with_file_and_skeleton(): void
    {
        $options = $this->getResourceFileAsArray('test-package-model');
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        //     '$content' => $content,
        //     '$options' => $options,
        // ]);

        $instance = new Package($options, true);

        $instance->apply();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$instance' => $instance,
        //     // 'json_encode($instance)' => json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        //     // '$options' => $options,
        // ]);
        // echo(json_encode($instance, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        $this->assertEmpty($instance->folder());
        $this->assertTrue($instance->skeleton());

        $this->assertSame('Playground', $instance->organization());
        $this->assertSame('playground-cms', $instance->package());
        $this->assertSame('gammamatrix/playground-cms', $instance->packagist());
        $this->assertSame('Cms', $instance->module());
        $this->assertSame('cms', $instance->module_slug());
        $this->assertSame('Playground/Cms/ServiceProvider', $instance->fqdn());
        $this->assertSame('Playground/Cms', $instance->namespace());
        $this->assertSame('Playground/Cms/ServiceProvider', $instance->name());
        $this->assertSame('ServiceProvider', $instance->class());
        $this->assertSame('', $instance->type());
        $this->assertSame('playground', $instance->service_provider());
        $this->assertSame([
            'laravel',
            'playground',
            'cms',
        ], $instance->package_keywords());
        $this->assertSame([
            'php' => '^8.2',
        ], $instance->package_require());
        $this->assertSame([], $instance->package_require_dev());
        $this->assertSame([], $instance->package_autoload_psr4());
        $this->assertSame([
            'Playground/Cms/ServiceProvider',
        ], $instance->package_laravel_providers());
        $this->assertSame([], $instance->controllers());
        $this->assertSame([
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.abstract.json',
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.abstract-page.json',
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.abstract-snippet.json',
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.page.json',
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.snippet.json',
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.page-revision.json',
            'vendor/gammamatrix/playground-stub/resources/playground/cms/model.snippet-revision.json',
        ], $instance->models());
        $this->assertSame([], $instance->policies());
        $this->assertSame([], $instance->routes());
        $this->assertFalse($instance->factories());
    }
}
