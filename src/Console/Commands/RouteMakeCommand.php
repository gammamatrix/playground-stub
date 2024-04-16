<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Route as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\RouteMakeCommand
 */
#[AsCommand(name: 'playground:make:route')]
class RouteMakeCommand extends GeneratorCommand
{
    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    const CONFIGURATION = [
        'class' => '',
        'controller' => '',
        'extends' => '',
        'name' => '',
        'folder' => '',
        'namespace' => 'App',
        'model' => '',
        'model_column' => '',
        'model_label' => '',
        'model_slug_plural' => '',
        'module' => '',
        'module_slug' => '',
        'organization' => '',
        'package' => '',
        'config' => '',
        'type' => '',
        'route' => '',
        'route_prefix' => '',
        // 'base_route' => 'welcome',
        'title' => '',
        // stubs/route/playground/resource-index-section.stub
    ];

    const SEARCH = [
        'route' => '',
        // 'base_route' => 'welcome',
        'extends' => '',
        'class' => '',
        'controller' => '',
        'folder' => '',
        'namespace' => '',
        'organization' => '',
        'namespacedModel' => '',
        'NamespacedDummyUserModel' => '',
        'namespacedUserModel' => '',
        'user' => '',
        'model' => '',
        'modelVariable' => '',
        'model_column' => '',
        'model_label' => '',
        'model_slug_plural' => '',
        'module' => '',
        'module_slug' => '',
        'title' => '',
        'package' => '',
        'config' => '',
        'route_prefix' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new route group';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    protected string $path_destination_folder = 'routes';

    public function prepareOptions(): void
    {
        $options = $this->options();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        // ]);

        $type = $this->getConfigurationType();

        if (! empty($options['route']) && is_string($options['route'])) {
            $this->c->setOptions([
                'route' => $options['route'],
            ]);
            $this->searches['route'] = $this->c->route();
        }

        if (! empty($options['prefix']) && is_string($options['prefix'])) {
            // NOTE this might need slash handling
            $this->c->setOptions([
                'route_prefix' => $options['route_prefix'],
            ]);
            $this->searches['route_prefix'] = $this->c->route_prefix();
        }

        if (! empty($options['title']) && is_string($options['title'])) {
            $this->c->setOptions([
                'title' => $options['title'],
            ]);
            $this->searches['title'] = $this->c->title();
        }

        if (! empty($this->configuration['config']) && is_string($this->configuration['config'])) {
            $this->searches['config'] = Str::of($this->configuration['config'])->snake()->replace('-', '_')->toString();
        }

        if (! empty($options['extends']) && is_string($options['extends'])) {
            $this->c->setOptions([
                'extends' => $options['extends'],
            ]);
            $this->searches['extends'] = $this->c->extends();
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     'test_1' => empty($this->configuration['config']),
        //     'test_2' => empty($this->configuration['config']) && !empty($options['package']),
        //     'test_3' => empty($this->configuration['config']) && !empty($options['package']) && is_string($options['package']),
        //     '$type' => $type,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     '$this->options()' => $this->options(),
        // ]);

        // if (empty($this->configuration['config'])
        //     && !empty($options['package'])
        //     && is_string($options['package'])
        // ) {
        //     $this->configuration['config'] = Str::of($options['package'])->snake()->toString();
        //     $this->searches['config'] = $this->configuration['config'];
        // } else {
        //     $this->configuration['config'] = '';
        //     $this->searches['config'] = '';
        // }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    // /**
    //  * Build the class with the given name.
    //  *
    //  * @param  string  $name
    //  * @return string
    //  */
    // protected function buildClass($name)
    // {
    //     // $this->buildClass_model($name);
    //     return parent::buildClass($name);
    // }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     */
    protected function qualifyClass($name): string
    {
        $type = $this->getConfigurationType();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        // ]);

        if (! $this->c->folder()) {
            $this->c->setOptions([
                'folder' => Str::of($name)->kebab()->toString(),
            ]);
            $this->searches['folder'] = $this->c->folder();
        }

        if (! $this->c->model_column()) {

            $this->c->setOptions([
                'model_column' => Str::of($name)->snake()->replace('-', '_')->toString(),
                'model_label' => Str::of($name)->title()->toString(),
                'model_slug_plural' => Str::of($this->c->model_column())->plural()->toString(),
            ]);

            $this->searches['model_column'] = $this->c->model_column();
            $this->searches['model_label'] = $this->c->model_label();
            $this->searches['model_slug_plural'] = $this->c->model_slug_plural();
        }

        if ($type === 'site') {
            $this->c->setOptions([
                'class' => $this->c->model_column(),
                'route_prefix' => $this->c->module_slug(),
            ]);
        } elseif ($type === 'playground') {
            $this->c->setOptions([
                'class' => $this->c->model_slug_plural(),
                'route_prefix' => $this->c->module_slug(),
            ]);
        } elseif ($type === 'playground-resource-index') {
            $this->c->setOptions([
                'class' => $this->c->module_slug(),
                'route_prefix' => sprintf(
                    'resource/%1$s',
                    $this->c->module_slug()
                ),
            ]);
        } elseif ($type === 'playground-resource') {
            $this->c->setOptions([
                'class' => $this->c->module_slug(),
                'route_prefix' => sprintf(
                    'resource/%1$s/%2$s',
                    $this->c->module_slug(),
                    $this->c->model_slug_plural()
                ),
            ]);
        } elseif ($type === 'playground-api-index') {
            $this->c->setOptions([
                'class' => $this->c->module_slug(),
                'route_prefix' => sprintf(
                    'api/%1$s',
                    $this->c->module_slug()
                ),
            ]);
        } elseif ($type === 'playground-api') {
            $this->c->setOptions([
                'class' => $this->c->model_slug_plural(),
                'route_prefix' => sprintf(
                    'api/%1$s/%2$s',
                    $this->c->module_slug(),
                    $this->c->model_slug_plural()
                ),
            ]);
        } else {
            $this->c->setOptions([
                'class' => $this->c->model_column(),
                'route_prefix' => $this->c->module_slug(),
            ]);
        }

        $this->c->setOptions([
            'controller' => Str::of($name)->studly()->finish('Controller')->toString(),
        ]);

        $this->searches['controller'] = $this->c->controller();
        $this->searches['route_prefix'] = $this->c->route_prefix();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        //     '$this->options()' => $this->options(),
        // ]);
        return $this->c->class();
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $route = 'route/playground-resource-index.php.stub';

        $type = $this->getConfigurationType();

        if ($type === 'site') {
            $route = 'route/playground-resource-index.php.stub';
        } elseif ($type === 'playground') {
            $route = 'route/playground-resource-index.php.stub';
        } elseif ($type === 'playground-resource-index') {
            $route = 'route/playground-resource-index.php.stub';
        } elseif ($type === 'playground-resource') {
            $route = 'route/playground-resource.php.stub';
        }

        return $this->resolveStubPath($route);
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        // $options[] = ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the route applies to'],;
        $options[] = ['route', null, InputOption::VALUE_OPTIONAL, 'The base route for breadcrumbs.'];
        $options[] = ['title', null, InputOption::VALUE_OPTIONAL, 'The title of the base route for breadcrumbs.'];
        $options[] = ['prefix', null, InputOption::VALUE_OPTIONAL, 'The prefix slug for the route.'];
        // $options[] = ['roles-action', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles for action.'];
        // $options[] = ['roles-view', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles to view.'];

        return $options;
    }
}
