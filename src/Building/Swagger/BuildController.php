<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Swagger;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Swagger\BuildController
 */
trait BuildController
{
    protected string $build_controller_description = '';

    /**
     * @var array<string, mixed>
     */
    protected array $build_controller_properties = [];

    protected function doc_controller(): void
    {
        $name = $this->c->name();
        if (empty($name)) {
            $this->components->error('Docs: The name must be set in the [controller] configuration');

            return;
        }
        $controller_type = $this->c->controller_type();
        if (in_array($controller_type, [
            'playground-api',
            'playground-resource',
            'resource',
            'api',
        ])) {
            // Add the tag for the model.
            $this->api->addTag($name);

            $this->doc_controller_id($name, $controller_type);
            // $this->doc_controller_index($name, $controller_type);
        }

        // if (in_array($controller_type, [
        //     'playground-resource',
        //     'resource',
        // ])) {
        //     $this->doc_controller_lock($name, $controller_type);
        //     $this->doc_controller_restore($name, $controller_type);
        // }
    }

    protected function doc_controller_id(
        string $name,
        string $controller_type = ''
    ): void {

        // Initialize the ID path
        $pathId = $this->api->controllers()->pathId([
        ]);

        $this->doc_controller_id_config($name, $controller_type);

        // $this->api->controllers()->pathId([

        // ]);
        $this->doc_request_id($name, $controller_type);

        $path = sprintf(
            '/api/%1$s/{id}',
            Str::of($name)->plural()->kebab()->toString()
        );
        $file = sprintf(
            'paths/%1$s/id.yml',
            Str::of($name)->plural()->kebab()->toString()
        );

        $this->api->addPath($path, $file);
        $this->api->apply();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$controller_type' => $controller_type,
        //     '$this->api->apply()->properties()' => $this->api->apply()->properties(),
        //     'json - $this->api->apply()->properties()' => json_decode(json_encode($this->api->apply()->jsonSerialize()), true),
        //     // '$this->model' => $this->model,
        //     // '$this->configuration' => $this->configuration,
        //     // '$this->searches' => $this->searches,
        //     // '$this->arguments()' => $this->arguments(),
        //     // '$this->options()' => $this->options(),
        // ]);

        $this->yaml_write(
            $file,
            $this->api->controllers()->pathId()->apply()->toArray()
        );
    }

    protected function doc_controller_id_config(
        string $name,
        string $controller_type = ''
    ): void {

        $this->api->controllers()->pathId()->addParameter($name, [
            'in' => 'path',
            'name' => 'id',
            'required' => true,
            // 'description' => 'The %1$s id.',
            'schema' => [
                'type' => 'string',
                'format' => 'uuid',
            ],
        ]);

        // if (! empty($config['parameters']) && ! empty($name)) {

        //     if (! empty($config['parameters'][0])
        //         && ! empty($config['parameters'][0]['description'])
        //         && ! empty($config['parameters'][0]['name'])
        //         && $config['parameters'][0]['name'] === 'id'
        //     ) {
        //         $config['parameters'][0]['description'] = sprintf(
        //             $config['parameters'][0]['description'],
        //             Str::of($name)->lower()
        //         );
        //     }
        // }

        // if (! empty($config['get']) && ! empty($name)) {

        //     if (empty($config['get']['tags']) || ! is_array($config['get']['tags'])) {
        //         $config['get']['tags'] = [];
        //     }

        //     $tag = Str::of($name)->title()->toString();

        //     if (! in_array($tag, $config['get']['tags'])) {
        //         $config['get']['tags'][] = $tag;
        //     }

        //     if (! empty($config['get']['summary'])) {
        //         $config['get']['summary'] = sprintf(
        //             $config['get']['summary'],
        //             Str::of($name)->lower()
        //         );
        //     }

        //     if (! empty($config['get']['operationId'])) {
        //         $config['get']['operationId'] = sprintf(
        //             $config['get']['operationId'],
        //             Str::of($name)->snake()
        //         );
        //     }

        //     if (! empty($config['get']['responses']) && ! empty($config['get']['responses'][200])) {
        //         $config['get']['responses'][200]['description'] = sprintf(
        //             $config['get']['responses'][200]['description'],
        //             Str::of($name)->lower()
        //         );
        //         $config['get']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'] = sprintf(
        //             $config['get']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'],
        //             Str::of($name)->kebab()
        //         );
        //     }
        // }

        // if (! empty($config['delete']) && ! empty($name)) {

        //     if (empty($config['delete']['tags']) || ! is_array($config['delete']['tags'])) {
        //         $config['delete']['tags'] = [];
        //     }

        //     $tag = Str::of($name)->title()->toString();

        //     if (! in_array($tag, $config['delete']['tags'])) {
        //         $config['delete']['tags'][] = $tag;
        //     }

        //     if (! empty($config['delete']['summary'])) {
        //         $config['delete']['summary'] = sprintf(
        //             $config['delete']['summary'],
        //             Str::of($name)->lower()->toString()
        //         );
        //     }

        //     if (! empty($config['delete']['operationId'])) {
        //         $config['delete']['operationId'] = sprintf(
        //             $config['delete']['operationId'],
        //             Str::of($name)->snake()->toString()
        //         );
        //     }

        //     if (! empty($config['delete']['responses']) && ! empty($config['delete']['responses'][204])) {
        //         $config['delete']['responses'][204]['description'] = sprintf(
        //             $config['delete']['responses'][204]['description'],
        //             Str::of($name)->lower()->toString()
        //         );
        //         $config['delete']['responses'][423]['description'] = sprintf(
        //             $config['delete']['responses'][423]['description'],
        //             Str::of($name)->lower()->toString()
        //         );
        //     }
        // }

        // if (! empty($config['patch']) && ! empty($name)) {

        //     if (empty($config['patch']['tags']) || ! is_array($config['patch']['tags'])) {
        //         $config['patch']['tags'] = [];
        //     }

        //     $tag = Str::of($name)->title()->toString();

        //     if (! in_array($tag, $config['patch']['tags'])) {
        //         $config['patch']['tags'][] = $tag;
        //     }

        //     if (! empty($config['patch']['summary'])) {
        //         $config['patch']['summary'] = sprintf(
        //             $config['patch']['summary'],
        //             Str::of($name)->lower()->toString()
        //         );
        //     }

        //     if (! empty($config['patch']['operationId'])) {
        //         $config['patch']['operationId'] = sprintf(
        //             $config['patch']['operationId'],
        //             Str::of($name)->snake()->toString()
        //         );
        //     }

        //     if (! empty($config['patch']['responses']) && ! empty($config['patch']['responses'][200])) {
        //         $config['patch']['responses'][200]['description'] = sprintf(
        //             $config['patch']['responses'][200]['description'],
        //             Str::of($name)->lower()->toString()
        //         );
        //         $config['patch']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'] = sprintf(
        //             $config['patch']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'],
        //             Str::of($name)->kebab()->toString()
        //         );
        //     }
        // }
    }

    // protected function doc_controller_index(
    //     string $name,
    //     string $controller_type = ''
    // ): void {
    //     $config = config('playground-stub.controller.index');

    //     $this->doc_controller_index_config($config, $name, $controller_type);

    //     $this->doc_request_index($config, $name, $controller_type);

    //     // dump([
    //     //     '__METHOD__' => __METHOD__,
    //     //     '$controller_type' => $controller_type,
    //     //     '$config' => $config,
    //     //     // '$this->model' => $this->model,
    //     //     // '$this->configuration' => $this->configuration,
    //     //     // '$this->searches' => $this->searches,
    //     //     // '$this->arguments()' => $this->arguments(),
    //     //     // '$this->options()' => $this->options(),
    //     // ]);

    //     $path = sprintf(
    //         '/api/%1$s',
    //         Str::of($name)->plural()->kebab()->toString()
    //     );
    //     $file = sprintf(
    //         'paths/%1$s/index.yml',
    //         Str::of($name)->plural()->kebab()->toString()
    //     );

    //     $this->api->addPath($path, $file);
    //     $this->yaml_write($file, $config);
    // }

    // protected function doc_controller_index_config(
    //     string $name,
    //     string $controller_type = ''
    // ): void {
    //     if (! empty($config['get']) && ! empty($name)) {

    //         if (empty($config['get']['tags']) || ! is_array($config['get']['tags'])) {
    //             $config['get']['tags'] = [];
    //         }

    //         $tag = Str::of($name)->title()->toString();

    //         if (! in_array($tag, $config['get']['tags'])) {
    //             $config['get']['tags'][] = $tag;
    //         }

    //         if (! empty($config['get']['summary'])) {
    //             $config['get']['summary'] = sprintf(
    //                 $config['get']['summary'],
    //                 Str::of($name)->lower()->plural()
    //             );
    //         }

    //         if (! empty($config['get']['operationId'])) {
    //             $config['get']['operationId'] = sprintf(
    //                 $config['get']['operationId'],
    //                 Str::of($name)->plural()->snake()
    //             );
    //         }

    //         if (! empty($config['get']['responses']) && ! empty($config['get']['responses'][200])) {
    //             $config['get']['responses'][200]['description'] = sprintf(
    //                 $config['get']['responses'][200]['description'],
    //                 Str::of($name)->plural()->snake()->toString()
    //             );
    //             $config['get']['responses'][200]['content']['application/json']['schema']['properties']['data']['items']['$ref'] = sprintf(
    //                 $config['get']['responses'][200]['content']['application/json']['schema']['properties']['data']['items']['$ref'],
    //                 Str::of($name)->kebab()->toString()
    //             );
    //         }
    //     }

    //     if (! empty($config['post']) && ! empty($name)) {

    //         if (empty($config['post']['tags']) || ! is_array($config['post']['tags'])) {
    //             $config['post']['tags'] = [];
    //         }

    //         $tag = Str::of($name)->title()->toString();

    //         if (! in_array($tag, $config['post']['tags'])) {
    //             $config['post']['tags'][] = $tag;
    //         }

    //         if (! empty($config['post']['summary'])) {
    //             $config['post']['summary'] = sprintf(
    //                 $config['post']['summary'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //         }

    //         if (! empty($config['post']['operationId'])) {
    //             $config['post']['operationId'] = sprintf(
    //                 $config['post']['operationId'],
    //                 Str::of($name)->snake()->toString()
    //             );
    //         }

    //         if (! empty($config['post']['responses']) && ! empty($config['post']['responses'][200])) {
    //             $config['post']['responses'][200]['description'] = sprintf(
    //                 $config['post']['responses'][200]['description'],
    //                 Str::of($name)->plural()->snake()->toString()
    //             );
    //             $config['post']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'] = sprintf(
    //                 $config['post']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'],
    //                 Str::of($name)->kebab()->toString()
    //             );
    //         }
    //     }
    // }

    // protected function doc_controller_lock(
    //     string $name,
    //     string $controller_type = ''
    // ): void {
    //     $config = config('playground-stub.controller.lock');

    //     $this->doc_controller_lock_config($config, $name, $controller_type);

    //     $path = sprintf(
    //         '/api/%1$s/lock/{id}',
    //         Str::of($name)->plural()->kebab()->toString()
    //     );
    //     $file = sprintf(
    //         'paths/%1$s/lock.yml',
    //         Str::of($name)->plural()->kebab()->toString()
    //     );

    //     $this->api->addPath($path, $file);
    //     $this->yaml_write($file, $config);
    // }

    // protected function doc_controller_lock_config(
    //     string $name,
    //     string $controller_type = ''
    // ): void {

    //     if (! empty($config['parameters']) && ! empty($name)) {

    //         if (! empty($config['parameters'][0])
    //             && ! empty($config['parameters'][0]['description'])
    //             && ! empty($config['parameters'][0]['name'])
    //             && $config['parameters'][0]['name'] === 'id'
    //         ) {
    //             $config['parameters'][0]['description'] = sprintf(
    //                 $config['parameters'][0]['description'],
    //                 Str::of($name)->lower()
    //             );
    //         }
    //     }

    //     if (! empty($config['delete']) && ! empty($name)) {

    //         if (empty($config['delete']['tags']) || ! is_array($config['delete']['tags'])) {
    //             $config['delete']['tags'] = [];
    //         }

    //         $tag = Str::of($name)->title()->toString();

    //         if (! in_array($tag, $config['delete']['tags'])) {
    //             $config['delete']['tags'][] = $tag;
    //         }

    //         if (! empty($config['delete']['summary'])) {
    //             $config['delete']['summary'] = sprintf(
    //                 $config['delete']['summary'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //         }

    //         if (! empty($config['delete']['operationId'])) {
    //             $config['delete']['operationId'] = sprintf(
    //                 $config['delete']['operationId'],
    //                 Str::of($name)->snake()->toString()
    //             );
    //         }

    //         if (! empty($config['delete']['responses']) && ! empty($config['delete']['responses'][204])) {
    //             $config['delete']['responses'][204]['description'] = sprintf(
    //                 $config['delete']['responses'][204]['description'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //         }
    //     }

    //     if (! empty($config['put']) && ! empty($name)) {

    //         if (empty($config['put']['tags']) || ! is_array($config['put']['tags'])) {
    //             $config['put']['tags'] = [];
    //         }

    //         $tag = Str::of($name)->title()->toString();

    //         if (! in_array($tag, $config['put']['tags'])) {
    //             $config['put']['tags'][] = $tag;
    //         }

    //         if (! empty($config['put']['summary'])) {
    //             $config['put']['summary'] = sprintf(
    //                 $config['put']['summary'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //         }

    //         if (! empty($config['put']['operationId'])) {
    //             $config['put']['operationId'] = sprintf(
    //                 $config['put']['operationId'],
    //                 Str::of($name)->snake()->toString()
    //             );
    //         }

    //         if (! empty($config['put']['responses']) && ! empty($config['put']['responses'][200])) {
    //             $config['put']['responses'][200]['description'] = sprintf(
    //                 $config['put']['responses'][200]['description'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //             $config['put']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'] = sprintf(
    //                 $config['put']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'],
    //                 Str::of($name)->kebab()->toString()
    //             );
    //         }
    //     }

    // }

    // protected function doc_controller_restore(
    //     string $name,
    //     string $controller_type = ''
    // ): void {
    //     $config = config('playground-stub.controller.restore');

    //     $this->doc_controller_restore_config($config, $name, $controller_type);

    //     $path = sprintf(
    //         '/api/%1$s/restore/{id}',
    //         Str::of($name)->plural()->kebab()->toString()
    //     );
    //     $file = sprintf(
    //         'paths/%1$s/restore.yml',
    //         Str::of($name)->plural()->kebab()->toString()
    //     );

    //     $this->api->addPath($path, $file);
    //     $this->yaml_write($file, $config);
    // }

    // protected function doc_controller_restore_config(
    //     string $name,
    //     string $controller_type = ''
    // ): void {

    //     if (! empty($config['parameters']) && ! empty($name)) {

    //         if (! empty($config['parameters'][0])
    //             && ! empty($config['parameters'][0]['description'])
    //             && ! empty($config['parameters'][0]['name'])
    //             && $config['parameters'][0]['name'] === 'id'
    //         ) {
    //             $config['parameters'][0]['description'] = sprintf(
    //                 $config['parameters'][0]['description'],
    //                 Str::of($name)->lower()
    //             );
    //         }
    //     }

    //     if (! empty($config['put']) && ! empty($name)) {

    //         if (empty($config['put']['tags']) || ! is_array($config['put']['tags'])) {
    //             $config['put']['tags'] = [];
    //         }

    //         $tag = Str::of($name)->title()->toString();

    //         if (! in_array($tag, $config['put']['tags'])) {
    //             $config['put']['tags'][] = $tag;
    //         }

    //         if (! empty($config['put']['summary'])) {
    //             $config['put']['summary'] = sprintf(
    //                 $config['put']['summary'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //         }

    //         if (! empty($config['put']['operationId'])) {
    //             $config['put']['operationId'] = sprintf(
    //                 $config['put']['operationId'],
    //                 Str::of($name)->snake()->toString()
    //             );
    //         }

    //         if (! empty($config['put']['responses']) && ! empty($config['put']['responses'][200])) {
    //             $config['put']['responses'][200]['description'] = sprintf(
    //                 $config['put']['responses'][200]['description'],
    //                 Str::of($name)->lower()->toString()
    //             );
    //             $config['put']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'] = sprintf(
    //                 $config['put']['responses'][200]['content']['application/json']['schema']['properties']['data']['$ref'],
    //                 Str::of($name)->kebab()->toString()
    //             );
    //         }
    //     }

    // }
}
