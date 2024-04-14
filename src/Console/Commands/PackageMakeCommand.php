<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
// use Symfony\Component\Console\Input\InputArgument;
use Playground\Stub\Configuration\Package as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\PackageMakeCommand
 */
#[AsCommand(name: 'playground:make:package')]
class PackageMakeCommand extends GeneratorCommand
{
    use Concerns\ComposerJson;
    use Concerns\PackageSkeleton;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    // const CONFIGURATION = [
    //     'class' => 'ServiceProvider',
    //     'config' => '',
    //     'factories' => false,
    //     'package' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'name' => '',
    //     'namespace' => '',
    //     'organization' => '',
    //     // 'package' => '',
    //     'package_name' => '',
    //     'package_autoload' => '',
    //     'package_description' => '',
    //     'package_keywords' => [],
    //     'package_homepage' => '',
    //     'package_license' => '',
    //     'package_require' => [],
    //     'package_require_dev' => [],
    //     'package_autoload_psr4' => [],
    //     'package_laravel_providers' => [],
    //     'packagist' => '',
    //     'controllers' => [],
    //     'models' => [],
    //     'policies' => [],
    //     'routes' => [],
    //     'service_provider' => '',
    //     'version' => '1.0.0',
    // ];

    const SEARCH = [
        'class' => 'ServiceProvider',
        'module' => '',
        'module_slug' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        'package_name' => '',
        'package_autoload' => '',
        'package_description' => '',
        'package_keywords' => '',
        'package_homepage' => '',
        'package_license' => '',
        'package_require' => '',
        'package_require_dev' => '',
        'package_autoload_psr4' => '',
        'package_laravel_providers' => '',
        'packagist' => '',
        'policies' => '',
        'routes' => '',
        'version' => '1.0.0',
    ];

    protected string $path_destination_folder = 'src';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a package';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Package';

    protected bool $saveConfiguration = false;

    /**
     * Autoloading for the package.
     *
     * @var array<string, array<string, string>>
     */
    protected array $autoload = [
        'psr-4' => [],
    ];

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['factories', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model factories.'];
        $options[] = ['license', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' license.'];

        return $options;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        if ($this->hasOption('factories')
            && $this->option('factories')
        ) {
            $this->c->setOptions([
                'factories' => true,
            ]);
        }

        if ($this->hasOption('license')
            && is_string($this->option('license'))
            && $this->option('license')
        ) {
            $this->c->setOptions([
                'package_license' => $this->option('license'),
            ]);
            $this->searches['package_license'] = $this->c->package_license();
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$his->option(license)' => $this->option('license'),
        //     '$this->searches[package_license]' => $this->searches['package_license'],
        // ]);

        $this->createComposerJson($this->searches, $this->autoload);
        $this->createConfig($this->searches);
        $this->createSkeleton($this->searches);

        if ($this->hasOption('policies')
            && is_array($this->option('policies'))
        ) {
            $this->c->setOptions([
                'policies' => $this->option('policies'),
            ]);
        }

        $this->handle_models();
        $this->handle_policies();
        // $this->handle_requests();
        $this->handle_controllers();

        $this->saveConfiguration();
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s.%2$s.json',
            Str::of($this->getType())->kebab(),
            Str::of($this->c->package())->kebab(),
        );
    }

    public function handle_controllers(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$controllers' => $controllers,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->controllers() as $controller) {
            if (is_string($controller) && $controller) {
                $params['--file'] = $controller;
                $this->call('playground:make:controller', $params);
            }
        }
    }

    public function handle_models(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$his->option(license)' => $this->option('license'),
        //     '$models' => $models,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->models() as $model) {
            if (is_string($model) && $model) {
                $params['--file'] = $model;
                $this->call('playground:make:model', $params);
            }
        }
    }

    public function handle_policies(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$his->option(license)' => $this->option('license'),
        //     '$policies' => $policies,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->policies() as $policy) {
            // $file = sprintf('', $policy);
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     // '$his->option(license)' => $this->option('license'),
            //     '$policy' => $policy,
            // ]);
            $params['--file'] = $policy;
            $this->call('playground:make:policy', $params);
        }

        // if (! class_exists($parentModelClass) &&
        //     confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", default: true)) {
        //     $this->call('playground:make:model', ['name' => $parentModelClass]);
        // }
    }

    public function handle_requests(): void
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$requests' => $requests,
        // ]);

        $params = [
            '--file' => '',
        ];

        if ($this->hasOption('force') && $this->option('force')) {
            $params['--force'] = true;
        }

        foreach ($this->c->requests() as $request) {
            if (is_string($request) && $request) {
                $params['--file'] = $request;
                // dump([
                //     '__METHOD__' => __METHOD__,
                //     '$request' => $request,
                // ]);
                $this->call('playground:make:request', $params);
            }
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        if (empty($this->searches['namespace'])) {
            $this->searches['namespace'] = $this->getNamespace($name);
        }

        if (empty($this->searches['organization'])
            && $this->hasOption('organization')
            && $this->option('organization')
            && is_string($this->option('organization'))
        ) {
            $this->searches['organization'] = $this->option('organization');
        }

        return parent::buildClass($name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $template = 'service-provider/ServiceProvider.stub';

        $type = $this->getConfigurationType();

        if (in_array($type, [
            'policies',
            'api',
            'resource',
        ])) {
            $template = 'service-provider/ServiceProvider-policies.stub';
        } elseif (in_array($type, [
            'playground',
        ])) {
            $template = 'service-provider/ServiceProvider-playground.stub';
        } elseif (in_array($type, [
            'playground-api',
            'playground-resource',
        ])) {
            $template = 'service-provider/ServiceProvider-playground-policies.stub';
        }

        return $this->resolveStubPath($template);
    }

    // /**
    //  * Get the destination class path.
    //  *
    //  * @param  string  $name
    //  * @return string
    //  */
    // protected function getPath($name)
    // {
    //     dd([
    //         '__METHOD__' => __METHOD__,
    //         '$name' => $name,
    //         'rootNamespace()' => $this->rootNamespace(),
    //     ]);
    //     $name = 'ServiceProvider';
    //     if (empty($this->searches['package'])) {
    //         $this->searches['package'] = Str::of($name)
    //             ->replaceFirst($this->rootNamespace(), '')
    //             ->replace('\\', '-')->ltrim('-')->slug('-')
    //             ->toString()
    //         ;
    //     }

    //     $this->folder = sprintf(
    //         '%1$s/%2$s',
    //         $this->getDestinationPath(),
    //         $this->searches['package']
    //     );

    //     $path = sprintf(
    //         '%1$s/src/ServiceProvider.php',
    //         $this->folder
    //     );
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     '$destinationPath' => $destinationPath,
    //     //     '$name' => $name,
    //     //     '$path' => $path,
    //     //     'rootNamespace()' => $this->rootNamespace(),
    //     // ]);

    //     return $this->laravel->storagePath().$path;
    // }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name): string
    {
        return trim(implode('\\', explode('\\', $name)), '\\');
        // return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }
}
