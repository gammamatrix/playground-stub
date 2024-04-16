<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Template as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\TemplateMakeCommand
 */
#[AsCommand(name: 'playground:make:template')]
class TemplateMakeCommand extends GeneratorCommand
{
    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    /**
     * @var array<string, mixed>
     */
    const CONFIGURATION = [
        'class' => '',
        'extends' => '',
        'name' => '',
        'folder' => '',
        'namespace' => 'App',
        'model' => '',
        'model_column' => '',
        'model_label' => '',
        'module' => '',
        'module_slug' => '',
        'organization' => '',
        'package' => '',
        'config' => '',
        'type' => '',
        'route' => 'welcome',
        // 'base_route' => 'welcome',
        'title' => '',
        // stubs/template/playground/resource-index-section.stub
        'sections' => [
            //     // 'title' => '',
            //     // 'subtitle' => '',
            //     // 'text' => '',
            //     // 'route' => '',
            //     // 'route_label' => '',
        ],
        'HasOne' => [],
    ];

    /**
     * @var array<string, string>
     */
    const SEARCH = [
        'route' => 'welcome',
        // 'base_route' => 'welcome',
        'extends' => 'playground::layouts.site',
        'class' => '',
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
        'module' => '',
        'module_slug' => '',
        'title' => 'Welcome',
        'sections' => '',
        'package' => '',
        'config' => '',
        'form_info_has_one' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new template set';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Template';

    protected string $path_destination_folder = 'resources/views';

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
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        // ]);

        if (empty($this->configuration['folder'])) {
            $this->c->setOptions([
                'folder' => Str::of($name)->kebab()->toString(),
            ]);
            $this->searches['folder'] = $this->c->folder();
        }

        if (empty($this->configuration['model_column'])) {
            $this->c->setOptions([
                'model_column' => Str::of($name)->snake()->replace('-', '_')->toString(),
                'model_label' => Str::of($name)->title()->toString(),
            ]);
            $this->searches['model_column'] = $this->c->model_column();
            $this->searches['model_label'] = $this->c->model_label();
        }

        if ($type === 'site') {
            $this->c->setOptions([
                'class' => sprintf('%1$s.blade', $this->c->folder()),
            ]);
        } elseif ($type === 'playground') {
            $this->c->setOptions([
                'class' => sprintf('%1$s.blade', $this->c->folder()),
            ]);
        } elseif ($type === 'playground-resource-index') {
            $this->c->setOptions([
                'class' => 'index.blade',
            ]);
        } elseif ($type === 'playground-resource') {
            $this->c->setOptions([
                'class' => sprintf('%1$s./index.blade', $this->c->folder()),
            ]);
        } else {
            $this->c->setOptions([
                'class' => sprintf('%1$s.blade', $this->c->folder()),
            ]);
        }

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
     * Execute the console command.
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        $type = $this->getConfigurationType();

        if ($type === 'playground-resource') {
            $this->handle_playground_resource();
        }

        $this->saveConfiguration();
    }

    protected function handle_playground_resource(): void
    {
        /**
         * @var array<string, string> $templates
         */
        $templates = [];

        $templates['detail.blade.php'] = 'template/playground/resource/model/detail.blade.php.stub';
        $templates['form.blade.php'] = 'template/playground/resource/model/form.blade.php.stub';
        $templates['form-info.blade.php'] = 'template/playground/resource/model/form-info.blade.php.stub';
        $templates['form-publishing.blade.php'] = 'template/playground/resource/model/form-publishing.blade.php.stub';
        $templates['form-status.blade.php'] = 'template/playground/resource/model/form-status.blade.php.stub';
        // $templates['index'] = 'template/playground/resource/model/index.blade.php.stub';

        foreach ($templates as $template => $source) {

            // $path_stub = 'template'.$template;
            $path = $this->resolveStubPath($source);

            $destination = sprintf(
                '%1$s/%2$s%3$s',
                $this->folder(),
                $this->c->folder() ? $this->c->folder().'/' : '',
                $template
            );
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$source' => $source,
            //     '$path' => $path,
            //     '$destination' => $destination,
            //     '$this->folder' => $this->folder(),
            // ]);
            $stub = $this->files->get($path);

            $this->search_and_replace($stub);

            $full_path = $this->laravel->storagePath().$destination;
            $this->files->put($full_path, $stub);

            $this->components->info(sprintf('Template: %s [%s] created successfully.', $template, $full_path));
        }
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $template = 'template/template.blade.php.stub';

        $type = $this->getConfigurationType();

        if ($type === 'site') {
            $template = 'template/playground/site.blade.php.stub';
        } elseif ($type === 'playground') {
            $template = 'template/playground/site.blade.php.stub';
        } elseif ($type === 'playground-resource-index') {
            $template = 'template/playground/resource/index.blade.php.stub';
        } elseif ($type === 'playground-resource') {
            $template = 'template/playground/resource/model/index.blade.php.stub';
        }

        return $this->resolveStubPath($template);
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        // $options[] = ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the template applies to'],;
        $options[] = ['route', null, InputOption::VALUE_OPTIONAL, 'The base route for breadcrumbs.'];
        $options[] = ['title', null, InputOption::VALUE_OPTIONAL, 'The title of the base route for breadcrumbs.'];
        $options[] = ['config', null, InputOption::VALUE_OPTIONAL, 'The config name that will be snake case.'];
        // $options[] = ['roles-action', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles for action.'];
        // $options[] = ['roles-view', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles to view.'];

        return $options;
    }
}
