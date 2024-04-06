<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace GammaMatrix\Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Package as Configuration;
// use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \GammaMatrix\Playground\Stub\Console\Commands\PackageMakeCommand
 */
#[AsCommand(name: 'playground:make:package')]
class PackageMakeCommand extends GeneratorCommand
{
    // use Traits\MakeComposerTrait;
    // use Traits\MakeSkeletonTrait;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    const CONFIGURATION = [
        'class' => 'ServiceProvider',
        'config' => '',
        'factories' => false,
        'package' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        // 'package' => '',
        'package_name' => '',
        'package_autoload' => '',
        'package_description' => '',
        'package_keywords' => [],
        'package_homepage' => '',
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
        'version' => '1.0.0',
    ];

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
     */
    protected array $autoload = [
        'psr-4' => [],
    ];

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        $options[] = ['factories', null, InputOption::VALUE_NONE, 'The '.strtolower($this->type).' will have model factories.'];
        $options[] = ['license', null, InputOption::VALUE_OPTIONAL, 'The '.strtolower($this->type).' license.'];

        return $options;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        if ($this->hasOption('factories')
            && $this->option('factories')
        ) {
            $this->configuration['factories'] = true;
        }

        if ($this->hasOption('license')
            && is_string($this->option('license'))
            && $this->option('license')
        ) {
            $this->searches['package_license'] = $this->option('license');
            $this->configuration['package_license'] = $this->option('license');
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
            if (empty($this->configuration['policies'])
                || ! is_array($this->configuration['policies'])
            ) {
                $this->configuration['policies'] = [];
            }
            foreach ($this->option('policies') as $policy) {
                if (! in_array($policy, $this->configuration['policies'])) {
                    $this->configuration['policies'][] = $policy;
                }
            }
        }

        if (! empty($this->configuration['models']
            && is_array($this->configuration['models'])
        )) {
            $this->handle_models($this->configuration['models']);
        }

        if (! empty($this->configuration['policies']
            && is_array($this->configuration['policies'])
        )) {
            $this->handle_policies($this->configuration['policies']);
        }

        if (! empty($this->configuration['requests'])
            && is_array($this->configuration['requests'])
        ) {
            $this->handle_requests($this->configuration['requests']);
        }

        if (! empty($this->configuration['controllers'])
            && is_array($this->configuration['controllers'])
        ) {
            $this->handle_controllers($this->configuration['controllers']);
        }

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

    public function handle_controllers(array $controllers)
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

        foreach ($controllers as $controller) {
            if (is_string($controller) && $controller) {
                $params['--file'] = $controller;
                $this->call('playground:make:controller', $params);
            }
        }
    }

    public function handle_models(array $models)
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

        foreach ($models as $model) {
            if (is_string($model) && $model) {
                $params['--file'] = $model;
                $this->call('playground:make:model', $params);
            }
        }
    }

    public function handle_policies(array $policies)
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

        foreach ($policies as $policy) {
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

    public function handle_requests(array $requests)
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

        foreach ($requests as $request) {
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
    protected function buildClass($name)
    {
        if (empty($this->searches['namespace'])) {
            $this->searches['namespace'] = $this->getNamespace($name);
        }

        if (empty($this->searches['organization'])
            && $this->hasOption('organization')
            && $this->option('organization')
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
    protected function getStub()
    {
        $template = 'service-provider/ServiceProvider.stub';

        $type = $this->configuration['service_provider'] ?? '';

        if ($type === 'policies') {
            $template = 'service-provider/ServiceProvider-policies.stub';
        } elseif ($type === 'playground') {
            $template = 'service-provider/ServiceProvider-playground.stub';
        } elseif ($type === 'playground-policies') {
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
    protected function getNamespace($name)
    {
        return trim(implode('\\', explode('\\', $name)), '\\');
        // return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }
}
