<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Controller\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Controller\Skeletons\BuildTemplates
 */
trait BuildTemplates
{
    public function skeleton_templates(string $type): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->hasOption('model') ? $this->option('model') : '';
        $module = $this->hasOption('module') ? $this->option('module') : '';
        $name = $this->argument('name');
        $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        $package = $this->hasOption('package') ? $this->option('package') : '';

        // $layout = 'playground::layouts.site';

        if (empty($model) && ! empty($this->c->model()) && is_string($this->c->model())) {
            $model = $this->c->model();
        }

        if (empty($module) && ! empty($this->c->module()) && is_string($this->c->module())) {
            $module = $this->c->module();
        }

        if (empty($namespace) && ! empty($this->c->namespace()) && is_string($this->c->namespace())) {
            $namespace = $this->c->namespace();
        }

        if (empty($package) && ! empty($this->c->package()) && is_string($this->c->package())) {
            $package = $this->c->package();
        }

        if (empty($organization) && ! empty($this->c->organization()) && is_string($this->c->organization())) {
            $organization = $this->c->organization();
        }

        $layout = 'playground::layouts.site';

        $options = [
            'name' => $name,
            '--namespace' => $namespace,
            '--force' => $force,
            '--package' => $package,
            '--organization' => $organization,
            '--model' => $model,
            '--module' => $module,
            '--type' => $type,
            '--class' => $name,
            '--title' => Str::of($this->c->name())->snake()->replace('_', ' ')->title()->toString(),
            // '--config' => Str::of($package)->snake()->toString(),
            '--extends' => $layout,
        ];

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $options['--model-file'] = $this->option('model-file');
        }

        if (! empty($this->c->route()) && is_string($this->c->route())) {
            $options['--route'] = $this->c->route();
        }

        if ($type === 'api') {
        } elseif ($type === 'resource') {
        } elseif ($type === 'playground-resource') {
        } elseif ($type === 'playground-resource-index') {
        } elseif ($type === 'playground-api') {
        }

        if (empty($this->call('playground:make:template', $options))) {

            $path_resources_templates = $this->getResourcePackageFolder();

            $file_request = sprintf(
                '%1$s%2$s/%3$s/template.json',
                $this->laravel->storagePath(),
                $path_resources_templates,
                Str::of($this->c->name())->kebab()
            );

            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$options' => $options,
            //     '$file_request' => $file_request,
            //     // '$path_resources_templates' => $path_resources_templates,
            //     // '$this->configuration' => $this->configuration,
            //     // '$this->laravel->storagePath()' => $this->laravel->storagePath(),
            // ]);

            if (! in_array($file_request, $this->c->templates())) {
                $this->c->templates()[] = $file_request;
            }
        }
    }
}
