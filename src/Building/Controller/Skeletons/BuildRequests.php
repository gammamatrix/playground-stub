<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Controller\Skeletons;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Controller\Skeletons\BuildRequests
 */
trait BuildRequests
{
    public function skeleton_requests(string $type): void
    {
        $requests = [];

        $force = $this->hasOption('force') && $this->option('force');
        $model = $this->c->model();
        $module = $this->c->module();
        $name = Str::of($this->c->name())->before('Controller')->studly()->toString();
        $namespace = $this->c->namespace();
        $organization = $this->c->organization();
        $package = $this->c->package();

        $extends = '';

        if ($type === 'api') {
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
            ];
        } elseif ($type === 'playground-api') {

            if ($namespace) {
                // $extends = sprintf('%1$s/Http/Requests/%2$s/FormRequest', $namespace, $name);
                $extends = sprintf('%1$s/Http/Requests/FormRequest', $namespace);
            }

            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
                '--extends' => 'GammaMatrix/Playground/Matrix/Resource/Http/Requests/AbstractIndexRequest',
            ];
            $requests['lock'] = [
                '--type' => 'lock',
                '--class' => 'LockRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
                '--extends' => 'GammaMatrix/Playground/Matrix/Resource/Http/Requests/AbstractStoreRequest',
            ];
            $requests['unlock'] = [
                '--type' => 'unlock',
                '--class' => 'UnlockRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
                '--extends' => 'GammaMatrix/Playground/Matrix/Resource/Http/Requests/AbstractUpdateRequest',
            ];
        } elseif ($type === 'playground-resource') {

            if ($namespace) {
                // $extends = sprintf('%1$s/Http/Requests/%2$s/FormRequest', $namespace, $name);
                $extends = sprintf('%1$s/Http/Requests/FormRequest', $namespace);
            }

            $requests['create'] = [
                '--type' => 'create',
                '--class' => 'CreateRequest',
            ];
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['edit'] = [
                '--type' => 'edit',
                '--class' => 'EditRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
                '--extends' => 'GammaMatrix/Playground/Matrix/Resource/Http/Requests/AbstractIndexRequest',
            ];
            $requests['lock'] = [
                '--type' => 'lock',
                '--class' => 'LockRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
                '--extends' => 'GammaMatrix/Playground/Matrix/Resource/Http/Requests/AbstractStoreRequest',
            ];
            $requests['unlock'] = [
                '--type' => 'unlock',
                '--class' => 'UnlockRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
                '--extends' => 'GammaMatrix/Playground/Matrix/Resource/Http/Requests/AbstractUpdateRequest',
            ];
        } elseif ($type === 'resource') {
            $requests['create'] = [
                '--type' => 'create',
                '--class' => 'CreateRequest',
            ];
            $requests['destroy'] = [
                '--type' => 'destroy',
                '--class' => 'DestroyRequest',
            ];
            $requests['edit'] = [
                '--type' => 'edit',
                '--class' => 'EditRequest',
            ];
            $requests['index'] = [
                '--type' => 'index',
                '--class' => 'IndexRequest',
            ];
            $requests['restore'] = [
                '--type' => 'restore',
                '--class' => 'RestoreRequest',
            ];
            $requests['show'] = [
                '--type' => 'show',
                '--class' => 'ShowRequest',
            ];
            $requests['store'] = [
                '--type' => 'store',
                '--class' => 'StoreRequest',
            ];
            $requests['update'] = [
                '--type' => 'update',
                '--class' => 'UpdateRequest',
            ];
        } else {
            $requests = [
                'index' => [
                    '--type' => 'index',
                    '--class' => 'IndexRequest',
                ],
            ];
        }

        foreach ($requests as $request) {
            if ($force) {
                $request['--force'] = true;
            }
            if ($namespace) {
                $request['--namespace'] = $namespace;
            }
            if ($package) {
                $request['--package'] = $package;
            }
            if ($organization) {
                $request['--organization'] = $organization;
            }
            if ($model) {
                $request['--model'] = $model;
            }
            if ($extends && empty($request['--extends'])) {
                $request['--extends'] = $extends;
            }
            if ($this->hasOption('model-file') && $this->option('model-file')) {
                $request['--model-file'] = $this->option('model-file');
            }
            $request['--skeleton'] = true;
            $request['--module'] = $module;
            // $request = array_merge([
            //     'name' => $this->argument('name'),
            // ], $request);
            $request['name'] = $name;
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$request' => $request,
            // ]);
            if (empty($this->call('playground:make:request', $request))) {

                $path_resources_packages = $this->getResourcePackageFolder();

                // $file_request = ('vendor/gammamatrix/playground-stub/resources/playground/matrix/resource/version/request.test.json');
                $file_request = sprintf(
                    '%1$s%2$s/%3$s',
                    $this->laravel->storagePath(),
                    $path_resources_packages,
                    $this->getConfigurationFilename_for_request($name, $request['--type'])
                );

                // dd([
                //     '__METHOD__' => __METHOD__,
                //     '$name' => $name,
                //     '$request' => $request,
                //     '$file_request' => $file_request,
                //     '$path_resources_packages' => $path_resources_packages,
                //     // '$this->c' => $this->c,
                //     '$this->laravel->storagePath()' => $this->laravel->storagePath(),
                // ]);

                if (! in_array($file_request, $this->c->requests())) {
                    $this->c->requests()[] = $file_request;
                }
            }
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->configuration' => $this->configuration,
            // ]);
        }
    }

    protected function getConfigurationFilename_for_request(string $name, string $type): string
    {
        return sprintf(
            '%1$s/request%2$s.json',
            Str::of($name)->kebab(),
            $type ? '.'.Str::of($type)->kebab() : ''
        );
    }
}
