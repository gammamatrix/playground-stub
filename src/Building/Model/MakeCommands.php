<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Model\MakeCommands
 */
trait MakeCommands
{
    /**
     * Create a factory file for the model.
     *
     * @see \Playground\Stub\Console\Commands\FactoryMakeCommand
     */
    protected function createFactory(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $options = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Factory')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $options['--model-file'] = $file;
        }

        if (! $this->hasOption('skeleton') && $this->option('skeleton')) {
            $options['--skeleton'] = true;
        }

        $this->call('playground:make:factory', $options);
    }

    /**
     * Create a migration file for the model.
     *
     * @see MigrationMakeCommand
     */
    protected function createMigration(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $options = [
            'name' => $this->c->name(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--model-file' => $file,
            '--type' => $this->c->type(),
            '--create' => true,
        ];

        if (! empty($file) && is_string($file)) {
            $options['--model-file'] = $file;
        }

        $this->call('playground:make:migration', $options);
    }

    /**
     * Create a controller for the model.
     *
     * @see PolicyMakeCommand
     * @see SeederMakeCommand
     * @see TestMakeCommand
     */
    protected function createController(): void
    {
        $resource = $this->hasOption('resource') && $this->option('resource');
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $namespace = $this->c->namespace();
        if ($namespace) {
            $namespace = $this->parseClassConfig($namespace);
            if ($this->isApi) {
                $namespace = Str::of($namespace)->finish('/Api')->studly()->toString();
            } elseif ($this->isResource) {
                $namespace = Str::of($namespace)->finish('/Resource')->studly()->toString();
            }
        }
        $package = $this->c->package();
        if ($package && $this->c->playground()) {
            if ($this->isApi) {
                $package = Str::of($package)->finish('-api')->toString();
            } elseif ($this->isResource) {
                $package = Str::of($package)->finish('-resource')->toString();
            }
        }

        $options = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Controller')->toString(),
            '--namespace' => $namespace,
            '--force' => $force,
            '--package' => $package,
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            // '--module-slug' => $this->c->module_slug(),
            // '--type' => $this->c->type(),
        ];

        if ($this->isApi) {
            $options['--api'] = true;
        } elseif ($this->isResource) {
            $options['--resource'] = true;
        } else {

        }

        if ($this->c->playground()) {
            $options['--playground'] = true;
        }

        if (! empty($file) && is_string($file)) {
            $options['--model-file'] = $file;
        }

        if ($this->c->skeleton()) {
            $options['--skeleton'] = true;
        } else {
            // if ($this->c->requests()) {
            //     $options['--requests'] = true;
            // }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);
        $this->call('playground:make:controller', $options);
    }

    /**
     * Create a policy file for the model.
     *
     * @see PolicyMakeCommand
     */
    protected function createPolicy(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $options = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Policy')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $options['--model-file'] = $file;
        }

        $this->call('playground:make:policy', $options);
    }

    /**
     * Create a seeder file for the model.
     *
     * @see SeederMakeCommand
     */
    protected function createSeeder(): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $options = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Seeder')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $options['--model-file'] = $file;
        }

        $this->call('playground:make:seeder', $options);
    }

    protected bool $createTest = false;

    /**
     * Create a test file for the model.
     *
     * @return void
     */
    protected function createTest()
    {
        if ($this->createTest) {
            // Test already created.
            return;
        }

        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');

        $options = [
            'name' => Str::of(class_basename($this->qualifiedName))
                ->studly()->finish('Test')->toString(),
            '--namespace' => $this->c->namespace(),
            '--force' => $force,
            '--package' => $this->c->package(),
            '--organization' => $this->c->organization(),
            '--model' => $this->c->model(),
            '--module' => $this->c->module(),
            '--type' => $this->c->type(),
        ];

        if (! empty($file) && is_string($file)) {
            $options['--model-file'] = $file;
        }

        $options['--suite'] = 'unit';
        $this->call('playground:make:test', $options);

        $options['--suite'] = 'feature';
        $this->call('playground:make:test', $options);

        $this->createTest = true;
    }
}
