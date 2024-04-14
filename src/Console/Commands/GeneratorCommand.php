<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

abstract class GeneratorCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->reset();

        // $this->folder = $this->getDestinationPath();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder' => $this->folder,
        // ]);

        $name = $this->getNameInput();

        if (empty($name)) {
            if ($this->hasOption('file') && $this->option('file')) {
                $this->components->error(sprintf('Please provide a valid configuration for [--file %s]', static::class));

                return false;
            }

            $error = 'Please provide a name for the package or provide a configuration with [--file]';

            // Check if interactive
            if ($this->interactive && $this->hasOption('interactive') && $this->option('interactive')) {
                $name = $this->interactive();
                dump([
                    '__METHOD__' => __METHOD__,
                    '$name' => $name,
                ]);
                if (! $name) {
                    $this->components->error('Interactive mode was canceled');

                    return false;
                }
            } else {
                if ($this->interactive) {
                    $error .= ' or use [--interactive] mode';
                }
                $this->components->error($error);

                return false;
            }
        }

        $name = $this->handleName($name);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        // ]);
        // First we need to ensure that the given name is not a reserved word within the PHP
        // language and that the class name will actually be valid. If it is not valid we
        // can error now and prevent from polluting the filesystem using invalid files.
        if ($this->isReservedName($name)) {
            $this->components->error('The name "'.$name.'" is reserved by PHP.');

            return false;
        }

        $this->qualifiedName = $this->qualifyClass($name);
        $this->c->setOptions([
            'fqdn' => $this->parseClassConfig($this->qualifiedName),
        ]);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     '$this->c' => $this->c->class(),
        // ]);

        $path = $this->getPath($this->qualifiedName);
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$path' => $path,
        // ]);

        // Next, We will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((! $this->hasOption('force') ||
             ! $this->option('force')) &&
             $this->alreadyExists($name)) {
            $this->components->error($this->type.' already exists.');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($this->qualifiedName)));

        $info = $this->type;

        if ($this->handleTestCreation($path)) {
            $info .= ' and test';
        }

        $this->components->info(sprintf('%s [%s] created successfully.', $info, $path));

        if ($this->saveConfiguration) {
            $this->saveConfiguration();
        }
    }

    public function handleName(string $name): string
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        if ($this->qualifiedNameStudly && ! ctype_upper($name)) {
            $name = Str::of($name)->studly()->toString();
        }

        $this->c->setOptions([
            'name' => $name,
        ]);

        return $name;
    }

    /**
     * Create the matching test case if requested.
     *
     * @param  string  $path
     * @return bool
     */
    protected function handleTestCreation($path)
    {
        return false;
        // if (! $this->option('test') && ! $this->option('pest') && ! $this->option('phpunit')) {
        //     return false;
        // }

        // return $this->callSilent('make:test', [
        //     'name' => Str::of($path)->after($this->laravel['path'])->beforeLast('.php')->append('Test')->replace('\\', '/'),
        //     '--pest' => $this->option('pest'),
        //     '--phpunit' => $this->option('phpunit'),
        // ]) == 0;
    }

    /**
     * Qualify the given model class base name.
     *
     * @return string
     */
    protected function qualifyModel(string $model)
    {
        $rootNamespace = $this->rootNamespace();

        // if (empty($this->configuration['modelspace'])
        //     || ! is_string($this->configuration['modelspace'])
        // ) {
        //     $modelspace = $rootNamespace.'\\Models';
        // } else {
        //     $modelspace = $this->configuration['modelspace'];
        // }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model' => $model,
        // ]);
        $model = ltrim($model, '\\/');
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model' => $model,
        // ]);

        $model = str_replace('/', '\\', $model);
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$model' => $model,
        // ]);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$model' => $model,
        //     '$rootNamespace' => $rootNamespace,
        // ]);

        return $model;
    }

    // /**
    //  * Get a list of possible model names.
    //  *
    //  * @return array<int, string>
    //  */
    // protected function possibleModels()
    // {
    //     $modelPath = is_dir(app_path('Models')) ? app_path('Models') : app_path();

    //     return collect((new Finder)->files()->depth(0)->in($modelPath))
    //         ->map(fn ($file) => $file->getBasename('.php'))
    //         ->sort()
    //         ->values()
    //         ->all();
    // }

    // /**
    //  * Get a list of possible event names.
    //  *
    //  * @return array<int, string>
    //  */
    // protected function possibleEvents()
    // {
    //     $eventPath = app_path('Events');

    //     if (! is_dir($eventPath)) {
    //         return [];
    //     }

    //     return collect((new Finder)->files()->depth(0)->in($eventPath))
    //         ->map(fn ($file) => $file->getBasename('.php'))
    //         ->sort()
    //         ->values()
    //         ->all();
    // }

    /**
     * Get the desired class name from the input.
     */
    protected function getNameInput(): ?string
    {
        $name = $this->hasArgument('name') ? $this->argument('name') : null;
        if (is_string($name)) {
            $name = trim($name);
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder' => $this->folder,
        //     '$name' => $name,
        //     'rootNamespace()' => $this->rootNamespace(),
        // ]);

        if (empty($name) && ! empty($this->c->name())) {
            $name = $this->c->name();
        }

        if (is_string($name) && empty($this->c->name())) {
            $this->c->setOptions([
                'name' => $name,
            ]);
        }

        $this->applyConfigurationToSearch();

        $this->prepareOptions();

        return is_string($name) ? $name : null;
    }
}
