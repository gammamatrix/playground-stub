<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Swagger;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Swagger\BuildRequest
 */
trait BuildRequest
{
    protected function doc_request_id(
        string $name,
        string $controller_type = ''
    ): void {

        // $this->api->controllers()->add____($path, $file);

        // $file_model = sprintf(
        //     '%1$s/docs/models/%2$s.yml',
        //     $this->getPackageFolder(),
        //     Str::of($name)->kebab()
        // );
        // $path_docs_model = $this->laravel->storagePath().$file_model;

        // $model = $this->yaml_read($path_docs_model);
        // $hasFillable = ! empty($this->model) && ! empty($this->model['fillable']) && is_array($this->model['fillable']);
        // $hasProperties = ! empty($model['properties']) && is_array($model['properties']);

        // if (! $hasFillable) {
        //     if (array_key_exists('requestBody', $config['patch'])) {
        //         unset($config['patch']['requestBody']);
        //     }
        // }

        // if (array_key_exists('requestBody', $config['patch'])) {
        //     if (empty($config['patch']['requestBody']['content'])
        //         || ! is_array($config['patch']['requestBody']['content'])
        //     ) {
        //         $config['patch']['requestBody']['content'] = [];
        //     }
        //     if (empty($config['patch']['requestBody']['content']['application/json'])
        //         || ! is_array($config['patch']['requestBody']['content']['application/json'])
        //     ) {
        //         $config['patch']['requestBody']['content']['application/json'] = [];
        //     }
        //     if (empty($config['patch']['requestBody']['content']['application/json']['schema'])
        //         || ! is_array($config['patch']['requestBody']['content']['application/json']['schema'])
        //     ) {
        //         $config['patch']['requestBody']['content']['application/json']['schema'] = [];
        //     }
        //     $config['patch']['requestBody']['content']['application/json']['schema']['$ref'] = sprintf(
        //         $config['patch']['requestBody']['content']['application/json']['schema']['$ref'],
        //         Str::of($name)->lower()
        //     );
        // }

        // $patch = [
        //     'description' => sprintf(
        //         'The %1$s%2$s fillable properties.',
        //         empty($this->configuration['module']) ? '' : $this->configuration['module'].' ',
        //         Str::of($name)->toString()
        //     ),
        //     'type' => 'object',
        //     'properties' => [],
        // ];

        // if ($hasProperties && $hasFillable) {

        //     $modelConfiguration = $this->getModelConfiguration();
        //     foreach ($model['properties'] as $column => $property) {
        //         if (in_array($column, $this->model['fillable'])) {

        //             $column_meta = $this->buildClass_model_meta($column, $modelConfiguration);

        //             if (! empty($column_meta['readOnly'])) {
        //                 continue;
        //             }

        //             $patch['properties'][$column] = $property;
        //         }
        //     }
        // }

        // // dd([
        // //     '__METHOD__' => __METHOD__,
        // //     '$hasFillable' => $hasFillable,
        // //     '$hasProperties' => $hasProperties,
        // //     '$name' => $name,
        // //     // '$file_model' => $file_model,
        // //     // '$path_docs_model' => $path_docs_model,
        // //     // '$model' => $model,
        // //     '$controller_type' => $controller_type,
        // //     // '$config' => $config,
        // //     // '$this->model' => $this->model,
        // //     // '$this->configuration' => $this->configuration,
        // //     // '$this->searches' => $this->searches,
        // //     // '$this->arguments()' => $this->arguments(),
        // //     // '$this->options()' => $this->options(),
        // //     '$patch' => $patch,
        // // ]);

        $patch = [];
        $file = sprintf(
            'requests/%1$s/patch.yml',
            Str::of($name)->kebab()
        );

        $this->yaml_write($file, $patch);
    }

    // protected function doc_request_index(
    //     array &$config,
    //     string $name,
    //     string $controller_type = ''
    // ): void {

    //     $file_model = sprintf(
    //         '%1$s/docs/models/%2$s.yml',
    //         $this->getPackageFolder(),
    //         Str::of($name)->kebab()->toString()
    //     );
    //     $path_docs_model = $this->laravel->storagePath().$file_model;

    //     $model = $this->yaml_read($path_docs_model);
    //     $hasFillable = ! empty($this->model) && ! empty($this->model['fillable']) && is_array($this->model['fillable']);
    //     $hasProperties = ! empty($model['properties']) && is_array($model['properties']);

    //     if (! $hasFillable) {
    //         if (array_key_exists('requestBody', $config['post'])) {
    //             unset($config['post']['requestBody']);
    //         }
    //     }

    //     if (array_key_exists('requestBody', $config['post'])) {
    //         if (empty($config['post']['requestBody']['content'])
    //             || ! is_array($config['post']['requestBody']['content'])
    //         ) {
    //             $config['post']['requestBody']['content'] = [];
    //         }
    //         if (empty($config['post']['requestBody']['content']['application/json'])
    //             || ! is_array($config['post']['requestBody']['content']['application/json'])
    //         ) {
    //             $config['post']['requestBody']['content']['application/json'] = [];
    //         }
    //         if (empty($config['post']['requestBody']['content']['application/json']['schema'])
    //             || ! is_array($config['post']['requestBody']['content']['application/json']['schema'])
    //         ) {
    //             $config['post']['requestBody']['content']['application/json']['schema'] = [];
    //         }
    //         $config['post']['requestBody']['content']['application/json']['schema']['$ref'] = sprintf(
    //             $config['post']['requestBody']['content']['application/json']['schema']['$ref'],
    //             Str::of($name)->lower()->toString()
    //         );
    //     }

    //     $post = [
    //         'description' => sprintf(
    //             'The %1$s%2$s fillable properties.',
    //             empty($this->configuration['module']) ? '' : $this->configuration['module'].' ',
    //             Str::of($name)
    //         ),
    //         'type' => 'object',
    //         'properties' => [],
    //     ];

    //     if ($hasProperties && $hasFillable) {

    //         foreach ($model['properties'] as $column => $property) {
    //             if (in_array($column, $this->model['fillable'])) {

    //                 $column_meta = $this->buildClass_model_meta($column, $this->model);

    //                 if (! empty($column_meta['readOnly'])) {
    //                     continue;
    //                 }

    //                 $post['properties'][$column] = $property;
    //             }
    //         }
    //     }

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     '$hasFillable' => $hasFillable,
    //     //     '$hasProperties' => $hasProperties,
    //     //     '$name' => $name,
    //     //     // '$file_model' => $file_model,
    //     //     // '$path_docs_model' => $path_docs_model,
    //     //     // '$model' => $model,
    //     //     '$controller_type' => $controller_type,
    //     //     // '$config' => $config,
    //     //     // '$this->model' => $this->model,
    //     //     // '$this->configuration' => $this->configuration,
    //     //     // '$this->searches' => $this->searches,
    //     //     // '$this->arguments()' => $this->arguments(),
    //     //     // '$this->options()' => $this->options(),
    //     //     '$post' => $post,
    //     // ]);

    //     $file = sprintf(
    //         'requests/%1$s/post.yml',
    //         Str::of($name)->kebab()->toString()
    //     );

    //     $this->yaml_write($file, $post);
    // }
}
