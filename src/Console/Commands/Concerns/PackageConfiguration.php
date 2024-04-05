<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands\Concerns;

use Illuminate\Support\Str;

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

    /**
     * @var ?array<string, mixed>
     */
    protected ?array $model = null;

    /**
     * @var array<string, mixed>
     */
    protected array $configuration = [
        'class' => '',
        'model' => '',
        // 'models' => [],
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => 'app',
    ];

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

    protected bool $saveConfiguration = true;

    protected ?string $path_to_configuration = null;

    /**
     * @return array<string, mixed>
     */
    abstract protected function get_configuration(): array;

    /**
     * @return array<string, string>
     */
    abstract protected function get_search(): array;

    /**
     * @return array<string, mixed>
     */
    protected function getModelConfiguration(): ?array
    {
        return $this->model;
    }

    /**
     * @return array<string, mixed>
     */
    protected function loadOptionsIntoConfiguration(mixed $configuration): array
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->configuration' => $this->configuration,
        //     // '$configuration' => $configuration,
        // ]);
        if (! is_array($configuration)) {
            $this->components->error('Unable to load the invalid configuration.');
        } else {
            $this->configuration = array_replace(
                $this->configuration,
                $configuration
            );
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->searches' => $this->searches,
        //     '$this->configuration' => $this->configuration,
        // ]);

        return $this->configuration;
    }

    /**
     * @return array<string, string>
     */
    protected function applyConfigurationToSearch(): array
    {
        foreach ($this->searches as $search => $value) {
            if (array_key_exists($search, $this->configuration)) {
                if (is_string($this->configuration[$search])) {
                    if (in_array($search, [
                        'namespace',
                    ])) {
                        $this->searches[$search] = $this->parseClassInput($this->getDefaultNamespace($this->configuration[$search]));
                    } elseif (in_array($search, [
                        'class',
                        'model_fqdn',
                        'fqdn',
                        'model',
                    ])) {
                        $this->searches[$search] = $this->parseClassInput($this->configuration[$search]);
                    } else {
                        $this->searches[$search] = $this->configuration[$search];
                    }
                }
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches' => $this->searches,
        // ]);
        return $this->searches;
    }

    protected function getConfigurationByKeyAsString(
        string $key,
        string $default = ''
    ): string {
        return array_key_exists($key, $this->configuration)
            && is_string($this->configuration[$key])
            ? $this->configuration[$key] : $default;
    }

    protected function getConfigurationByKey(
        string $key,
        mixed $default = null
    ): mixed {
        return array_key_exists($key, $this->configuration)
            ? $this->configuration[$key] : $default;
    }

    protected function isConfigurationByKeyEmpty(string $key): bool
    {
        return ! array_key_exists($key, $this->configuration)
            || empty($this->configuration[$key]);
    }

    protected function setConfigurationByKey(
        string $key,
        mixed $value
    ): void {
        $default = $this->get_configuration();

        if (array_key_exists($key, $default)) {
            if (gettype($default[$key]) !== gettype($value)) {
                dump([
                    '__METHOD__' => __METHOD__,
                    '$key' => $key,
                    '$value' => $value,
                    '$default' => $default,
                ]);
                throw new \Exception('The types do not match for setConfigurationByKey()');
            }
        }

        $this->configuration[$key] = $value;
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
        $this->configuration = $this->get_configuration();
        $this->searches = $this->get_search();
        $this->path_to_configuration = null;

        $this->resetName();
        $this->resetNamespace();

        if ($this->hasOption('preload') && $this->option('preload')) {
            $this->preloadConfiguration();
        }

        $this->resetFile();

        $this->resetModelFile();

        $this->resetOptions();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder' => $this->folder,
        //     '$this->configuration' => $this->configuration,
        //     '$this->options()' => $this->options(),
        //     // '$this->model' => $this->model,
        // ]);
    }

    public function resetName(): void
    {
        if ($this->hasArgument('name')
            && $this->argument('name')
        ) {
            $this->configuration['name'] = $this->parseClassInput($this->argument('name'));
            $this->searches['name'] = $this->configuration['name'];
        }
    }

    public function resetNamespace(): void
    {
        $hasOptionPackage = $this->hasOption('package') && is_string($this->option('package')) && $this->option('package');
        $hasOptionOrganization = $this->hasOption('organization') && is_string($this->option('organization')) && $this->option('organization');

        if ($this->hasOption('namespace')
            && $this->option('namespace')
        ) {
            $this->configuration['namespace'] = $this->parseClassConfig($this->option('namespace'));
            $this->searches['namespace'] = $this->parseClassInput($this->getDefaultNamespace($this->configuration['namespace']));
            // $this->searches['namespace'] =  $this->configuration['namespace'];

            $package = [];

            foreach (Str::of($this->configuration['namespace'])
                ->replace('\\', '.')
                ->replace('/', '.')
                ->explode('.') as $i => $value
            ) {
                if ($i === 0) {
                    if (! $hasOptionOrganization && is_string($value)) {
                        $this->configuration['organization'] = $value;
                        $this->searches['organization'] = $this->configuration['organization'];
                    }
                } elseif (is_string($value) && $value) {
                    $package[] = Str::slug($value, '-');
                }
            }

            if (! $hasOptionPackage && ! empty($package)) {
                $this->configuration['package'] = implode('-', $package);
                $this->searches['package'] = $this->configuration['package'];
            }

        }
    }

    public function resetFile(): void
    {
        if ($this->hasOption('file')
            && $this->option('file')
            && is_string($this->option('file'))
            && $this->files->exists($this->option('file'))
        ) {
            $this->loadOptionsIntoConfiguration(
                $this->files->json($this->option('file'))
            );
        }
    }

    public function resetModelFile(): void
    {
        $model_file = null;

        if (is_array($this->configuration)) {

            if (! empty($this->configuration['name'])
            && is_string($this->configuration['name'])
            && ! empty($this->configuration['models'])
                && is_array($this->configuration['models'])
            ) {
                if (! empty($this->configuration['models'][$this->configuration['name']])
                    && is_string($this->configuration['models'][$this->configuration['name']])
                ) {
                    $model_file = $this->configuration['models'][$this->configuration['name']];
                }
            }
        }

        if ($model_file && $this->preloadModelFile && file_exists($model_file)) {
            $contents = file_get_contents($model_file);
            if ($contents) {
                $model = json_decode($contents, true);
                if (is_array($model)) {
                    $this->model = $model;
                }
            }
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

        if ($model_file && is_string($model_file) && file_exists($model_file)) {
            $contents = file_get_contents($model_file);
            if ($contents) {
                $model = json_decode($contents, true);
                if (is_array($model) && $this->model) {
                    $this->model = array_replace($this->model, $model);
                } elseif (is_array($model)) {
                    $this->model = $model;
                }
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model_file ' => $model_file,
        //     'file_exists($model_file) ' => file_exists($model_file),
        //     '$this->model ' => $this->model,
        // ]);
        if (! empty($this->model['name']) && is_string($this->model['name'])) {

            if (empty($this->configuration['models'])
                || ! is_array($this->configuration['models'])
            ) {
                $this->configuration['models'] = [];
            }
            $this->configuration['models'][$this->model['name']] = $model_file;

            if (empty($this->model['fqdn']) || ! is_string($this->model['fqdn'])) {

                if (! empty($this->model['namespace'])
                    && is_string($this->model['namespace'])
                    && ! empty($this->model['name'])
                    && is_string($this->model['name'])
                ) {
                    $this->model['fqdn'] = sprintf(
                        '%1$s\Models\%2$s',
                        trim($this->parseClassInput($this->model['namespace']), '\\/'),
                        trim(Str::of($this->model['name'])->studly()->toString(), '\\/')
                    );
                }
            }

            if (empty($this->configuration['model'])
                && ! $hasOptionModel
                && ! empty($this->model['fqdn'])
                && is_string($this->model['fqdn'])
            ) {
                $this->configuration['model'] = $this->parseClassConfig($this->model['fqdn']);
                $this->searches['model'] = $this->parseClassInput($this->model['fqdn']);
            }
        }

    }

    public function resetOptions(): void
    {
        // $this->resetName();

        // if ($this->hasArgument('name')
        //     && $this->argument('name')
        // ) {
        //     $this->configuration['name'] = $this->parseClassInput($this->argument('name'));
        //     $this->searches['name'] =  $this->configuration['name'];
        // }

        $hasOptionClass = $this->hasOption('class') && is_string($this->option('class')) && $this->option('class');
        $hasOptionModel = $this->hasOption('model') && is_string($this->option('model')) && $this->option('model');
        $hasOptionModule = $this->hasOption('module') && is_string($this->option('module')) && $this->option('module');
        $hasOptionOrganization = $this->hasOption('organization') && is_string($this->option('organization')) && $this->option('organization');
        $hasOptionPackage = $this->hasOption('package') && is_string($this->option('package')) && $this->option('package');
        $hasOptionType = $this->hasOption('type') && is_string($this->option('type')) && $this->option('type');

        // $this->resetNamespace();

        // if ($this->hasOption('namespace')
        //     && $this->option('namespace')
        // ) {
        //     $this->configuration['namespace'] = $this->parseClassConfig($this->option('namespace'));
        //     $this->searches['namespace'] = $this->parseClassInput($this->getDefaultNamespace($this->configuration['namespace']));
        //     // $this->searches['namespace'] =  $this->configuration['namespace'];

        //     $package = [];

        //     foreach (Str::of($this->configuration['namespace'])
        //         ->replace('\\', '.')
        //         ->replace('/', '.')
        //         ->explode('.') as $i => $value
        //     ) {
        //         if (0 === $i) {
        //             if (!$hasOptionOrganization && is_string($value)) {
        //                 $this->configuration['organization'] = $value;
        //                 $this->searches['organization'] = $this->configuration['organization'];
        //             }
        //         } elseif (is_string($value) && $value) {
        //             $package[] = Str::slug($value, '-');
        //         }
        //     };

        //     if (!$hasOptionPackage && !empty($package)) {
        //         $this->configuration['package'] = implode('-', $package);
        //         $this->searches['package'] =  $this->configuration['package'];
        //     }

        // }

        if ($hasOptionType && is_string($this->option('type'))) {
            $this->configuration['type'] = $this->option('type');
            $this->searches['type'] = $this->configuration['type'];
        }

        $hasNamespace = is_string($this->configuration['namespace']) && ! empty($this->configuration['namespace']);

        if ($hasOptionClass && is_string($this->option('class'))) {
            $this->configuration['class'] = $this->option('class');
            $this->searches['class'] = $this->parseClassInput($this->configuration['class']);
        }

        if ($hasOptionPackage && is_string($this->option('package'))) {
            $this->configuration['package'] = Str::slug($this->option('package'), '-');
            $this->searches['package'] = $this->configuration['package'];
        }

        $hasPackage = is_string($this->configuration['package']) && ! empty($this->configuration['package']);

        if ($hasOptionOrganization && is_string($this->option('organization'))) {
            $this->configuration['organization'] = $this->option('organization');
            $this->searches['organization'] = $this->configuration['organization'];
        }

        $hasOrganization = is_string($this->configuration['organization']) && ! empty($this->configuration['organization']);

        if ($hasOptionModel && is_string($this->option('model'))) {
            $this->configuration['model'] = $this->option('model');
            $this->searches['model'] = class_basename($this->parseClassInput($this->configuration['model']));
        }

        if ($hasOptionModule && is_string($this->option('module'))) {
            $this->configuration['module'] = $this->option('module');
            $this->searches['module'] = class_basename($this->parseClassInput($this->configuration['module']));

            $this->configuration['module'] = Str::of($this->configuration['module'])->snake()->replace('-', '_')->title()->toString();
            $this->searches['module'] = $this->configuration['module'];
            $this->configuration['module_slug'] = Str::slug($this->configuration['module'], '/');
            $this->searches['module_slug'] = $this->configuration['module_slug'];
        }

        if (array_key_exists('config', $this->configuration) && empty($this->configuration['config'])) {
            $this->configuration['config'] = $this->configuration['package'];
        }

        // if (empty($this->configuration['config']) && !empty($this->configuration['package'])) {
        //     $this->configuration['class'] = $this->parseClassInput($this->option('class'));
        // }

        // $this->resetModelFile()

        // if ($this->hasOption('model-file')
        //     && $this->option('model-file')
        // ) {
        //     $model_file = $this->option('model-file');
        //     if (file_exists($model_file)) {
        //         $this->model = json_decode(file_get_contents($model_file), true);
        //     }

        //     // dump([
        //     //     '__METHOD__' => __METHOD__,
        //     //     '$model_file ' => $model_file,
        //     //     'file_exists($model_file) ' => file_exists($model_file),
        //     //     '$this->model ' => $this->model,
        //     // ]);
        //     if (!empty($this->model['name']) && is_string($this->model['name'])) {

        //         if (empty($this->configuration['models'])
        //             || ! is_array($this->configuration['models'])
        //         ) {
        //             $this->configuration['models'] = [];
        //         }
        //         $this->configuration['models'][$this->model['name']] = $model_file;

        //         if (empty($this->model['fqdn']) || ! is_string($this->model['fqdn'])) {

        //             if (! empty($this->model['namespace'])
        //                 && is_string($this->model['namespace'])
        //                 && ! empty($this->model['name'])
        //                 && is_string($this->model['name'])
        //             ) {
        //                 $this->model['fqdn'] = sprintf(
        //                     '%1$s\Models\%2$s',
        //                     trim($this->parseClassInput($this->model['namespace']), '\\/'),
        //                     trim(Str::of($this->model['name'])->studly(), '\\/')
        //                 );
        //             }
        //         }

        //         if (empty($this->configuration['model'])
        //             && !$hasOptionModel
        //             && !empty($this->model['fqdn'])
        //             && is_string($this->model['fqdn'])
        //         ) {
        //             $this->configuration['model'] = $this->parseClassConfig($this->model['fqdn']);
        //             $this->searches['model'] = $this->parseClassInput($this->model['fqdn']);
        //         }
        //     }
        // }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->type' => $this->type,
        //     '$this->configuration' => $this->configuration,
        //     // '$this->searches' => $this->searches,
        //     '$hasOptionModule' => $hasOptionModule,
        //     '$hasOptionPackage' => $hasOptionPackage,
        //     '$hasOptionOrganization' => $hasOptionOrganization,
        //     // '$this->model' => $this->model,
        // ]);

        $this->isReset = true;
    }

    public function prepareOptions(): void
    {
    }

    protected function getConfigurationType(): string
    {
        $type = $this->configuration['type'] ?? '';
        if (! $type || ! is_string($type)) {
            $type = $this->option('type');
            $this->configuration['type'] = is_string($type) ? $type : '';
        }

        return is_string($type) ? $type : '';
    }

    protected function getConfigurationFilename(): string
    {
        return ! is_string($this->configuration['name']) ? '' : sprintf(
            '%1$s.%2$s.json',
            Str::of($this->getType())->kebab(),
            Str::of($this->configuration['name'])->kebab(),
        );
    }

    protected function getPackageFolder(): string
    {
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->configuration' => $this->configuration,
        //     '$this->folder' => $this->folder,
        // ]);
        if (empty($this->configuration['package']) || ! is_string($this->configuration['package'])) {
            throw new \Exception('Expecting the package to be set.');
        }

        if (Str::of($this->configuration['package'])->contains(' ')
            || Str::of($this->configuration['package'])->contains('.')
            || Str::of($this->configuration['package'])->contains('/')
            || Str::of($this->configuration['package'])->contains('\\')
        ) {
            // Str::of($this->configuration['package'])->kebab()
            throw new \Exception(sprintf(
                'Invalid package name for folder: %s',
                $this->configuration['package'])
            );
        }

        return sprintf(
            '%1$s/%2$s',
            $this->path_destination,
            $this->configuration['package']
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
            $this->configuration = array_replace($this->configuration, $configuration);
        }

        return $configuration;
    }

    /**
     * @return array<string, mixed>
     */
    protected function saveConfiguration(): array
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

        $payload = json_encode($this->configuration, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

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

        return $this->configuration;
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
