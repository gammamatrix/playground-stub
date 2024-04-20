<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands\Concerns;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Console\Commands\Concerns\PackageConfiguration
 */
trait PackageConfiguration
{
    /**
     * @var string The destination in path in storage.
     */
    protected string $path_destination = '/app/stub';

    /**
     * The destination folder.
     */
    protected string $folder = '';

    /**
     * @var string The folder under.
     */
    protected string $path_destination_folder = '';

    protected bool $isReset = false;

    protected ?Model $model = null;

    protected ?bool $return_status = null;

    // /**
    //  * @var array<string, mixed>
    //  */
    // protected array $configuration = [
    //     'class' => '',
    //     'model' => '',
    //     // 'models' => [],
    //     'name' => '',
    //     'namespace' => '',
    //     'organization' => '',
    //     'package' => 'app',
    // ];

    /**
     * @var array<string, string>
     */
    protected array $searches = [
        'class' => '',
        'model' => '',
        'name' => '',
        'namespace' => 'App',
        'organization' => '',
        'package' => 'app',
    ];

    protected string $configurationType = '';

    protected ?string $path_to_configuration = null;

    protected function getModelConfiguration(): ?Model
    {
        return $this->model;
    }

    protected function loadOptionsIntoConfiguration(mixed $configuration): void
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$configuration' => $configuration,
        // ]);
        if (! is_array($configuration)) {
            $this->components->error('Unable to load the invalid configuration.');
        } else {
            $this->c->setOptions($configuration);
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        // ]);
    }

    /**
     * @return array<string, string>
     */
    protected function applyConfigurationToSearch(bool $apply = true): array
    {
        if ($apply) {
            $this->c->apply();
        }
        $properties = $this->c->properties();
        foreach ($this->searches as $search => $value) {
            if (array_key_exists($search, $properties)) {
                if (is_string($properties[$search])) {
                    if (in_array($search, [
                        'namespace',
                    ])) {
                        $this->searches[$search] = $this->parseClassInput($properties[$search]);
                        // $this->searches[$search] = $this->parseClassInput($this->getDefaultNamespace($properties[$search]));
                    } elseif (in_array($search, [
                        'class',
                        'model_fqdn',
                        'fqdn',
                        'model',
                    ])) {
                        $this->searches[$search] = $this->parseClassInput($properties[$search]);
                    } else {
                        $this->searches[$search] = $properties[$search];
                    }
                }
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$apply' => $apply,
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        // ]);
        return $this->searches;
    }

    protected function getConfigurationByKeyAsString(
        string $key,
        string $default = ''
    ): string {
        $properties = $this->c->properties();

        return array_key_exists($key, $properties)
            && is_string($properties[$key])
            ? $properties[$key] : $default;
    }

    protected function getConfigurationByKey(
        string $key,
        mixed $default = null
    ): mixed {
        $properties = $this->c->properties();

        return array_key_exists($key, $properties)
            ? $properties[$key] : $default;
    }

    protected function isConfigurationByKeyEmpty(string $key): bool
    {
        $properties = $this->c->properties();

        return ! array_key_exists($key, $properties)
            || empty($properties[$key]);
    }

    protected function setConfigurationByKey(
        string $key,
        mixed $value,
        bool $addable = true
    ): void {
        $properties = $this->c->properties();

        $settable = true;

        $exists = false;
        if (array_key_exists($key, $properties)) {
            $exists = true;
            if (gettype($properties[$key]) !== gettype($value)) {
                dump([
                    '__METHOD__' => __METHOD__,
                    '$key' => $key,
                    '$value' => $value,
                    '$properties' => $properties,
                ]);
                throw new \Exception('The types do not match for setConfigurationByKey()');
            }
        }

        if (! $addable && ! $exists) {
            $settable = false;
        }

        if ($settable) {
            $this->c->setOptions([
                $key => $value,
            ]);
        }
    }

    protected function getSearchByKey(
        string $key,
        string $default = ''
    ): string {
        return array_key_exists($key, $this->searches)
            && is_string($this->searches[$key])
            ? $this->searches[$key] : $default;
    }

    protected function setSearchByKey(
        string $key, mixed $value
    ): void {

        if (gettype($value) !== 'string') {
            dump([
                '__METHOD__' => __METHOD__,
                '$key' => $key,
                '$value' => $value,
            ]);
            throw new \Exception('The search key value must be a string for setSearchByKey()');
        }

        $this->searches[$key] = $value;
    }

    public function reset(): void
    {
        $this->model = null;
        $this->folder = '';
        $this->get_configuration(true);
        $this->searches = $this->get_search();
        $this->path_to_configuration = null;
        $this->return_status = null;

        $this->resetName();
        $this->resetNamespace();

        if ($this->hasOption('preload') && $this->option('preload')) {
            $this->preloadConfiguration();
        }

        $this->resetFile();

        $this->resetModelFile();

        // Reset options gets called after the file for CLI overrides
        $this->resetOptions();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder' => $this->folder,
        //     '$this->options()' => $this->options(),
        //     // '$this->model' => $this->model,
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        // ]);
    }

    public function resetName(): void
    {
        if ($this->hasArgument('name')
            && $this->argument('name')
        ) {
            $this->c->setOptions([
                'name' => $this->parseClassInput($this->argument('name')),
            ]);
            $this->searches['name'] = $this->c->name();
        }
    }

    /**
     * Reset the namespace
     *
     * The namespace will be set to App if the --namespace option is not provided.
     */
    public function resetNamespace(): void
    {
        $namespace = '';
        $organization = '';
        $package = '';

        if ( $this->hasOption('namespace')
            && $this->option('namespace')
            && is_string($this->option('namespace'))
        ) {
            $namespace = $this->option('namespace');
        }

        if (empty($namespace)) {
            $namespace = 'App';
        }

        $organization = '';

        if ( $this->hasOption('organization')
            && $this->option('organization')
            && is_string($this->option('organization'))
        ) {
            $organization = $this->option('organization');
        }

        if ( $this->hasOption('package')
            && $this->option('package')
            && is_string($this->option('package'))
        ) {
            $package = $this->option('package');
        }

        $this->c->setOptions([
            'namespace' => $this->parseClassConfig($this->parseClassInput(
                $this->getDefaultNamespace(
                    $namespace
                )
            )),
        ]);
        $this->searches['namespace'] = $this->parseClassInput(
            $this->c->namespace()
        );

        // $this->c->setOptions([
        //     'namespace' => $this->parseClassConfig($namespace),
        // ]);
        // $this->searches['namespace'] = $this->parseClassInput(
        //     $this->getDefaultNamespace(
        //         $this->c->namespace()
        //     )
        // );

        $namespace_exploded = [];

        foreach (Str::of($this->c->namespace())
            ->replace('\\', '.')
            ->replace('/', '.')
            ->explode('.') as $i => $value
        ) {
            if ($i === 0) {
                if (! $organization && is_string($value) && ! in_array($value, [
                    'Tests',
                    'tests',
                ])) {
                    $organization = $value;
                }
            } elseif (is_string($value) && $value) {
                $namespace_exploded[] = Str::slug($value, '-');
            }
        }

        $this->c->setOptions([
            'organization' => $organization,
        ]);
        $this->searches['organization'] = $this->c->organization();

        if ($organization && ! $package && count($namespace_exploded)) {
            $package = implode('-', $namespace_exploded);
        }

        if (empty($package)) {
            $package = 'app';
        }

        $this->c->setOptions([
            'package' => $package,
        ]);
        $this->searches['package'] = $this->c->package();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches' => $this->searches,
        //     '$this->c' => $this->c,
        //     '$this->options()' => $this->options(),
        // ]);
    }

    public function resetFile(): void
    {
        $file = '';
        $pathInApp = '';
        $pathInPackage = '';
        $payload = null;

        // if ($this->hasOption('file')
        //     && $this->option('file')
        //     && is_string($this->option('file'))
        //     && $this->files->exists($this->option('file'))
        // ) {
        //     $this->loadOptionsIntoConfiguration(
        //         $this->files->json($this->option('file'))
        //     );
        // }

        if ($this->hasOption('file')
            && $this->option('file')
            && is_string($this->option('file'))
        ) {
            $file = $this->option('file');
            $pathInApp = base_path($file);
            $pathInPackage = sprintf('%1$s/%2$s', dirname(dirname(dirname(__DIR__))), $file);
        } else {
            return;
        }

        if ($this->files->exists($pathInApp)) {
            $this->components->info(sprintf('Loading %s [%s] from the app [%s]', $this->type, $file, $pathInApp));
            $payload = $this->files->json($pathInApp);
        } elseif ($this->files->exists($pathInPackage)) {
            $this->components->info(sprintf('Loading %s [%s] from the package [%s]', $this->type, $file, $pathInApp));
            $payload = $this->files->json($pathInPackage);
        } elseif ($this->files->exists($file)) {
            $this->components->info(sprintf('Loading %s [%s]', $this->type, $file));
            $payload = $this->files->json($file);
        } else {
            $this->components->error(sprintf('Unable to find %s [%s] in the app [%s] or package [%s]', $this->type, $file, $pathInApp, $pathInPackage));
        }

        $this->loadOptionsIntoConfiguration($payload);
    }

    /**
     * Initialize the model
     *
     * Initializes the model from the configuration, if not set or provided
     * by --model-file.
     *
     * <code>
     * "model": "Contact",
     * "models": {
     *     "Contact": "resources/testing/configurations/test.model.crm.contact.json"
     * }
     * </code>
     */
    public function initModel(bool $withSkeleton = false, bool $reload = false): void
    {
        if (! $reload && $this->model) {
            if ($withSkeleton) {
                $this->model->withSkeleton();
            }

            return;
        }

        $model = method_exists($this->c, 'model') ? $this->c->model() : '';
        $models = method_exists($this->c, 'models') ? $this->c->models() : [];

        if (! empty($model) && ! empty($models[$model])) {

            $this->model = new Model(
                $this->readJsonFileAsArray($models[$model], false, 'Model File'),
                $withSkeleton
            );
            // if (file_exists($models[$model])) {

            //     $contents = file_get_contents($models[$model]);
            //     if ($contents) {
            //         $m = json_decode($contents, true);
            //         $this->model = new Model($m, $withSkeleton);
            //     }
            // }
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     'test' => !empty($model) && !empty($models[$model]),
        //     '$models[$model]' => $models[$model] ?? '',
        //     '$model' => $model,
        //     '$models' => $models,
        //     '$this->options()' => $this->options(),
        //     '$this->c->class()' => $this->c->class(),
        //     '$this->c->table()' => $this->c->table(),
        // ]);

    }

    public function resetModelFile(): void
    {
        $model_file = null;

        $name = $this->c->name();
        $models = [];
        if (method_exists($this->c, 'models')) {
            $models = $this->c->models();
        }

        if ($name && ! empty($models)) {
            if (! empty($models[$name])
                && is_string($models[$name])
            ) {
                $model_file = $models[$name];
            }
        }

        if ($model_file
            && $this->preloadModelFile
            // && file_exists($model_file)
        ) {
            $this->model = new Model(
                $this->readJsonFileAsArray($model_file, false, 'Model File')
            );
            // $contents = file_get_contents($model_file);
            // if ($contents) {
            //     $model = json_decode($contents, true);
            //     if (is_array($model)) {
            //         $this->model = new Model($model);
            //     }
            // }
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model_file' => $model_file,
        //     '$hasModel' => $hasModel,
        //     'file_exists($model_file) ' => file_exists($model_file),
        //     '$this->preloadModelFile' => $this->preloadModelFile,
        // ]);

        $hasOptionModel = $this->hasOption('model') && is_string($this->option('model')) && $this->option('model');

        if ($this->hasOption('model-file')
            && $this->option('model-file')
        ) {
            $model_file = $this->option('model-file');
        } elseif ($this->type === 'Model'
            && $this->hasOption('file')
            && $this->option('file')
        ) {
            $model_file = $this->option('file');
        }

        if ($model_file
            && is_string($model_file)
            // && file_exists($model_file)
        ) {

            $model = $this->readJsonFileAsArray($model_file, false, 'Model File');

            // $contents = file_get_contents($model_file);
            // if ($contents) {
            //     $model = json_decode($contents, true);
            if (is_array($model) && $this->model) {
                // $this->model = array_replace($this->model, $model);
                $this->model = new Model(array_replace($this->model->properties(), $model));
            } elseif (is_array($model)) {
                $this->model = new Model($model);
            }
            // }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model_file ' => $model_file,
        //     'file_exists($model_file) ' => file_exists($model_file),
        //     '$this->model ' => $this->model,
        // ]);
        if ($this->model?->name()) {

            $this->model->addMappedClassTo('models', $this->model->name(), $model_file);

            if (empty($this->model->fqdn())) {

                if ($this->model->namespace()) {
                    $this->c->setOptions(['fqdn' => sprintf(
                        '%1$s\Models\%2$s',
                        trim($this->parseClassInput($this->model->namespace()), '\\/'),
                        trim(Str::of($this->model->name())->studly()->toString(), '\\/')
                    ), ]);
                }
            }

            if (empty($this->c->model())
                && ! $hasOptionModel
                && ! empty($this->model->fqdn())
                && is_string($this->model->fqdn())
            ) {
                $this->c->setOptions([
                    'model' => $this->parseClassConfig($this->model->fqdn()),
                ]);
                $this->searches['model'] = $this->parseClassInput($this->model->fqdn());
            }
        }

    }

    public function resetOptions(): void
    {
        $hasOptionClass = $this->hasOption('class') && is_string($this->option('class')) && $this->option('class');
        $hasOptionModel = $this->hasOption('model') && is_string($this->option('model')) && $this->option('model');
        $hasOptionModule = $this->hasOption('module') && is_string($this->option('module')) && $this->option('module');
        $hasOptionOrganization = $this->hasOption('organization') && is_string($this->option('organization')) && $this->option('organization');
        $hasOptionPackage = $this->hasOption('package') && is_string($this->option('package')) && $this->option('package');
        $hasOptionSkeleton = $this->hasOption('skeleton') && ! empty($this->option('skeleton'));
        $hasOptionType = $this->hasOption('type') && is_string($this->option('type')) && $this->option('type');

        if ($hasOptionSkeleton && method_exists($this->c, 'withSkeleton')) {
            $this->c->withSkeleton();
        }

        if ($hasOptionType && is_string($this->option('type'))) {
            $this->c->setOptions([
                'type' => $this->option('type'),
            ]);
            $this->searches['type'] = $this->c->type();
        }

        $hasNamespace = is_string($this->c->namespace()) && ! empty($this->c->namespace());

        if ($hasOptionClass && is_string($this->option('class'))) {
            $this->c->setOptions([
                'class' => $this->option('class'),
            ]);
            $this->searches['class'] = $this->parseClassInput($this->c->class());
        }

        if ($hasOptionPackage && is_string($this->option('package'))) {
            $this->c->setOptions([
                'package' => Str::slug($this->option('package'), '-'),
            ]);
            $this->searches['package'] = $this->c->package();
        }

        $hasPackage = is_string($this->c->package()) && ! empty($this->c->package());

        if ($hasOptionOrganization && is_string($this->option('organization'))) {
            $this->c->setOptions([
                'organization' => $this->option('organization'),
            ]);
            $this->searches['organization'] = $this->c->organization();
        }

        $hasOrganization = is_string($this->c->organization()) && ! empty($this->c->organization());

        if ($hasOptionModel && is_string($this->option('model'))) {
            $this->c->setOptions([
                'model' => $this->option('model'),
            ]);
            $this->searches['model'] = class_basename($this->parseClassInput($this->c->model()));
        }

        if ($hasOptionModule && is_string($this->option('module'))) {
            $this->c->setOptions([
                'module' => $this->option('module'),
            ]);
            $this->searches['module'] = class_basename($this->parseClassInput($this->c->module()));

            // TODO: Setting module again?
            $this->c->setOptions([
                'module' => Str::of($this->c->module())->snake()->replace('-', '_')->title()->toString(),
            ]);
            $this->searches['module'] = $this->c->module();
            $this->c->setOptions([
                'module_slug' => Str::slug($this->c->module(), '/'),
            ]);
            $this->searches['module_slug'] = $this->c->module_slug();
        }

        if (empty($this->c->config())) {
            $this->c->setOptions([
                'config' => $this->c->package(),
            ]);
        }

        $this->isReset = true;
    }

    public function prepareOptions(): void
    {
    }

    protected function getConfigurationType(): string
    {
        $type = $this->c->type();
        if (! $type) {
            $type = $this->option('type');
            if (is_string($type)) {
                $this->c->setOptions([
                    'type' => $type,
                ]);
            }
        }

        return is_string($type) ? $type : '';
    }

    protected function getConfigurationFilename(): string
    {
        return ! is_string($this->c->name()) ? '' : sprintf(
            '%1$s.%2$s.json',
            Str::of($this->getType())->kebab(),
            Str::of($this->c->name())->kebab(),
        );
    }

    protected function getPackageFolder(): string
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->folder' => $this->folder,
        // ]);
        if (empty($this->c->package()) || ! is_string($this->c->package())) {
            throw new \Exception('Expecting the package to be set.');
        }

        if (Str::of($this->c->package())->contains(' ')
            || Str::of($this->c->package())->contains('.')
            || Str::of($this->c->package())->contains('/')
            || Str::of($this->c->package())->contains('\\')
        ) {
            // Str::of($this->c->package())->kebab()
            throw new \Exception(sprintf(
                'Invalid package name for folder: %s',
                $this->c->package())
            );
        }

        return sprintf(
            '%1$s/%2$s',
            $this->path_destination,
            $this->c->package()
        );
    }

    protected function getResourcePackageFolder(): string
    {
        return sprintf(
            '%1$s/resources/packages',
            $this->getPackageFolder()
        );
    }

    protected bool $preloadModelFile = true;

    /**
     * @return ?array<string, mixed>
     */
    protected function preloadConfiguration(): ?array
    {
        $configuration = null;
        $filename = $this->getConfigurationFilename();

        $path = sprintf(
            '%1$s/%2$s',
            $this->getResourcePackageFolder(),
            $filename
        );

        $fullpath = $this->laravel->storagePath().$path;

        if (file_exists($fullpath)) {
            $configuration = $this->files->json($fullpath);
        }

        if (! empty($configuration) && is_array($configuration)) {
            $this->c->setOptions($configuration);
        }

        return $configuration;
    }

    protected function saveConfiguration(): ConfigurationContract
    {
        $path_resources_packages = $this->getResourcePackageFolder();

        // $path = $this->getPackageFolder();

        $filename = $this->getConfigurationFilename();

        $path = sprintf(
            '%1$s/%2$s',
            $this->getResourcePackageFolder(),
            $filename
        );

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->configuration' => $this->configuration,
        //     '$filename' => $filename,
        //     '$path' => $path,
        //     '$this->folder' => $this->folder,
        // ]);

        $fullpath = $this->laravel->storagePath().$path;

        $this->path_to_configuration = $fullpath;

        $this->makeDirectory($fullpath);

        $payload = json_encode($this->c->apply(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        if ($payload) {
            $this->files->put(
                $fullpath,
                $payload
            );

            $this->components->info(sprintf(
                'The configuration [%s] was saved in [%s]',
                $filename,
                $fullpath
            ));
        }

        return $this->c;
    }

    protected function getDestinationPath(): string
    {
        $path = $this->getPackageFolder();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$path' => $path,
        // ]);
        if ($this->path_destination_folder) {
            $path .= '/'.ltrim($this->path_destination_folder, '/');
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$path' => $path,
        // ]);

        return $path;
    }

    protected function folder(): string
    {
        if (empty($this->folder)) {
            $this->folder = $this->getDestinationPath();
        }

        return $this->folder;
    }
}
