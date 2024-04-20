<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Controller\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Controller\Skeletons\BuildPolicies
 */
trait BuildPolicies
{
    public function skeleton_policy(string $type): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $file = $this->option('file');
        // $module = $this->hasOption('module') ? $this->option('module') : '';
        // $name = $this->argument('name');
        // $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        // $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        // $package = $this->hasOption('package') ? $this->option('package') : '';

        // $layout = 'playground::layouts.site';

        // if (empty($model) && ! empty($this->c->model()) && is_string($this->c->model())) {
        //     $model = $this->c->model();
        // }

        // if (empty($module) && ! empty($this->c->module()) && is_string($this->c->module())) {
        //     $module = $this->c->module();
        // }

        // if (empty($namespace) && ! empty($this->c->namespace()) && is_string($this->c->namespace())) {
        //     $namespace = $this->c->namespace();
        // }

        // if (empty($package) && ! empty($this->c->package()) && is_string($this->c->package())) {
        //     $package = $this->c->package();
        // }

        // if (empty($organization) && ! empty($this->c->organization()) && is_string($this->c->organization())) {
        //     $organization = $this->c->organization();
        // }

        $params = [
            'name' => $this->c->name(),
            '--class' => Str::of(class_basename($this->qualifiedName))
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
            $params['--model-file'] = $file;
        }

        // $options = [
        //     'name' => $name,
        //     '--namespace' => $namespace,
        //     '--force' => $force,
        //     '--package' => $package,
        //     '--organization' => $organization,
        //     '--model' => $model,
        //     '--module' => $module,
        //     '--type' => $type,
        //     '--class' => sprintf('%1$sPolicy', $name),
        // ];

        // if ($this->hasOption('model-file') && $this->option('model-file')) {
        //     $options['--model-file'] = $this->option('model-file');
        // }

        if ($type === 'api') {
        } elseif ($type === 'resource') {
        } elseif ($type === 'playground-resource') {
            $params['--roles-action'] = [
                'publisher',
                'manager',
                'admin',
                'root',
            ];
            $params['--roles-view'] = [
                'user',
                'staff',
                'publisher',
                'manager',
                'admin',
                'root',
            ];
        } elseif ($type === 'playground-api') {
            $params['--roles-action'] = [
                'publisher',
                'manager',
                'admin',
                'root',
            ];
            $params['--roles-view'] = [
                'user',
                'staff',
                'publisher',
                'manager',
                'admin',
                'root',
            ];
        }

        if (empty($this->call('playground:make:policy', $params))) {

            $path_resources_packages = $this->getResourcePackageFolder();

            $file = sprintf(
                '%1$s%2$s/%3$s/policy.json',
                $this->laravel->storagePath(),
                $path_resources_packages,
                Str::of($this->c->name())->kebab()
            );

            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$file' => $file,
            //     '$path_resources_packages' => $path_resources_packages,
            //     '$this->configuration' => $this->configuration,
            //     '$this->laravel->storagePath()' => $this->laravel->storagePath(),
            // ]);

            if (! in_array($file, $this->c->policies())) {
                $this->c->policies()[] = $file;
            }
        }
    }
}
