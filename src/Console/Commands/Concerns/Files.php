<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands\Concerns;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

/**
 * \Playground\Stub\Console\Commands\Concerns\Files
 */
trait Files
{
    /**
     * Load a JSON file.
     *
     * Path priority for relative files:
     * - base_path($file)
     * - base_path($file)
     *
     * @return array<string, mixed>
     */
    protected function readJsonFileAsArray(string $file, bool $required = true, string $name = 'file'): array
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        // ]);
        if (empty($file)) {
            throw new \RuntimeException(__('playground-stub::stub.Command.json.file.required'));
        }

        $stringable = Str::of($file);

        if (! $stringable->endsWith('.json')) {
            throw new \RuntimeException(__('playground-stub::stub.Command.json.file.json', [
                'file' => $file,
            ]));
        }

        $pathInApp = '';
        $pathInPackage = '';

        $payload = null;
        // $contents = null;

        // Check relative paths
        if (! $stringable->startsWith('/')) {

            $pathInApp = base_path($file);
            $pathInPackage = sprintf('%1$s/%2$s', dirname(dirname(dirname(dirname(__DIR__)))), $file);
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     'dirname(dirname(dirname(__DIR__)))' => dirname(dirname(dirname(dirname(__DIR__)))),
            //     '$file' => $file,
            //     '$pathInApp' => $pathInApp,
            //     '$file' => $pathInPackage,
            // ]);

            if ($this->files->exists($pathInApp)) {
                $this->components->info(sprintf('Loading %s [%s] from the app [%s]', $name, $file, $pathInApp));
                // $contents = file_get_contents($pathInApp);
                $payload = $this->files->json($pathInApp);
            } elseif ($this->files->exists($pathInPackage)) {
                $this->components->info(sprintf('Loading %s [%s] from the package [%s]', $name, $file, $pathInApp));
                // $contents = file_get_contents($pathInPackage);
                $payload = $this->files->json($pathInPackage);
            } else {
                $this->components->error(sprintf('Unable to find %s [%s] in the app [%s] or package [%s]', $name, $file, $pathInApp, $pathInPackage));
            }

        } else {
            if ($this->files->exists($file)) {
                $this->components->info(sprintf('Loading %s [%s]', $name, $file));
                // $contents = file_get_contents($file);
                $payload = $this->files->json($file);
            } else {
                $this->components->error(sprintf('Unable to find %s [%s]', $name, $file));
            }
        }

        // // NOTE: An empty file is not necessarily an error when building skeletons.
        // if ($contents === false) {
        //     if ($required) {
        //         throw new \RuntimeException(__('playground-stub::stub.Command.json.file.invalid', [
        //             'file' => $file,
        //         ]));
        //     }
        // } elseif (! is_null($contents)) {
        //     $payload = json_decode($contents, true);
        //     if (json_last_error() && $required) {
        //         Log::debug(__METHOD__, [
        //             'file' => $file,
        //             'json_last_error_msg()' => json_last_error_msg(),
        //         ]);
        //         throw new \RuntimeException(__('playground-stub::stub.Command.json.file.invalid', [
        //             'file' => $file,
        //         ]));
        //     }
        // }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     'dir' => dirname(dirname(dirname(__DIR__))),
        //     '$file' => $file,
        //     '$required' => $required,
        //     '$pathInApp' => $pathInApp,
        //     '$pathInPackage' => $pathInPackage,
        //     // '$contents' => $contents,
        //     '$payload' => $payload,
        // ]);

        return is_array($payload) ? $payload : [];
    }

    // /**
    //  * Create the stub directory in storage for the generated code.
    //  */
    // protected function disk(): FilesystemAdapter
    // {
    //     $disk = config('playground-stub.disk');
    //     $disk = empty($disk) || ! is_string($disk) ? 'local' : $disk;

    //     return Storage::disk($disk);
    // }

    // /**
    //  * Create the stub directory in storage for the generated code.
    //  */
    // protected function createStubDirectory(): void
    // {
    //     if (!$this->disk()->exists('stub')) {
    //         $this->disk()->makeDirectory('stub');
    //     }
    // }

    // /**
    //  * Create the stub directory in storage for the generated code.
    //  */
    // protected function createTypeDirectory(): void
    // {
    //     if (!$this->disk()->exists('stub')) {
    //         $this->disk()->makeDirectory('stub');
    //     }
    // }

    // protected function getDestinationPath(): string
    // {
    //     $path = static::PATH_DESTINATION;

    //     if (! empty($this->c->package())) {
    //         $path .= '/'.ltrim($this->c->package(), '/');
    //     }

    //     if (static::PATH_DESTINATION_FOLDER) {
    //         $path .= '/'.ltrim(static::PATH_DESTINATION_FOLDER, '/');
    //     }

    //     return $path;
    // }
}
