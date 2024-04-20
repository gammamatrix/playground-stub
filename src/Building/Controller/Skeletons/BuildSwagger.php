<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Controller\Skeletons;

/**
 * \Playground\Stub\Building\Controller\Skeletons\BuildSwagger
 */
trait BuildSwagger
{
    public function skeleton_swagger(string $type): void
    {
        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->hasOption('model') ? $this->option('model') : '';
        $module = $this->hasOption('module') ? $this->option('module') : '';
        $name = $this->argument('name');
        $namespace = $this->hasOption('namespace') ? $this->option('namespace') : '';
        $organization = $this->hasOption('organization') ? $this->option('organization') : '';
        $package = $this->hasOption('package') ? $this->option('package') : '';

        $layout = 'playground::layouts.site';

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

        $options = [
            'name' => $name,
            '--namespace' => $namespace,
            '--force' => $force,
            '--package' => $package,
            '--organization' => $organization,
            '--model' => $model,
            '--module' => $module,
            // '--preload' => true,
            // '--type' => $type,
            '--type' => '',
        ];

        if ($this->hasOption('model-file') && $this->option('model-file')) {
            $options['--model-file'] = $this->option('model-file');
        }

        if ($type === 'api') {
        } elseif ($type === 'resource') {
        } elseif ($type === 'playground-resource') {
        } elseif ($type === 'playground-api') {
        }

        $options['--type'] = 'model';
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);

        if (empty($this->call('playground:make:swagger', $options))) {

            // $file_model = sprintf(
            //     '%1$s%2$s/%3$s/docs.model.json',
            //     $this->laravel->storagePath(),
            //     $path_resources_packages,
            //     Str::of($name)->kebab(),
            // );
            // if (! in_array($file_model, $this->c->docs())) {
            //     $this->c->docs()[] = $file_model;
            // }
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$path_resources_packages' => $path_resources_packages,
            //     '$file_model' => $file_model,
            //     '$this->configuration' => $this->configuration,
            // ]);
        }

        // art playground:make:controller Board --namespace GammaMatrix/Playground/Matrix/Resource --class BoardController --module Matrix --skeleton --force --type playground-resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.board.json
        // art playground:make:controller Board --namespace GammaMatrix/Playground/Matrix/Resource --class BoardController --module Matrix --skeleton --force --type playground-resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.board.json
        // art playground:make:controller Epic --namespace GammaMatrix/Playground/Matrix/Resource --class EpicController --module Matrix --skeleton --force --type playground-resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.epic.json
        // art playground:make:docs Board --type controller --controller-type playground-resource --namespace GammaMatrix/Playground/Matrix/Resource --model-file vendor/gammamatrix/playground-stub/resources/playground/matrix/model.board.json --preload --module Matrix
        $options['--type'] = 'controller';

        if (! empty($this->c->type())) {
            $options['--controller-type'] = $this->c->type();
        }

        // $path_resources_packages = $this->getResourcePackageFolder();

        if (empty($this->call('playground:make:swagger', $options))) {

            // $file_api = sprintf(
            //     '%1$s%2$s/docs.controller.json',
            //     $this->laravel->storagePath(),
            //     $path_resources_packages
            // );
            // if (! in_array($file_api, $this->c->docs())) {
            //     $this->c->docs()[] = $file_api;
            // }
        }
    }
}
