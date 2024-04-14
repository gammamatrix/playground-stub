<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands\Concerns;

// use Illuminate\Support\Facades\Storage;

/**
 * \Playground\Stub\Console\Commands\Concerns\PackageSkeleton
 */
trait PackageSkeleton
{
    /**
     * Create the configuration folder for the package.
     *
     * @param array<string, string> $searches
     */
    protected function createConfig(array &$searches): void
    {
        if (! $this->c->config()
            || ! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $this->c->config())
        ) {
            // Only create a config file if a valid filename is provided.
            $this->components->info('Skipping config file.');

            return;
        }

        // $destinationPath = $this->getDestinationPath();

        $path_stub = 'config/default.stub';
        $path = $this->resolveStubPath($path_stub);

        $file = sprintf(
            'config/%1$s.php',
            $this->c->config()
        );

        $destination = sprintf(
            '%1$s/%2$s',
            dirname($this->folder()),
            $file
        );

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$path_stub' => $path_stub,
        //     '$path' => $path,
        //     '$destination' => $destination,
        //     '$this->folder' => $this->folder,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     // '$stub' => $stub,
        //     // '$destination' => $destination,
        //     // '$searches' => $searches,
        //     '$this->rootNamespace()' => $this->rootNamespace(),
        // ]);

        $stub = $this->files->get($path);

        $this->search_and_replace($stub);

        $full_path = $this->laravel->storagePath().$destination;

        $this->makeDirectory($full_path);

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$full_path' => $full_path,
        //     'dirname($full_path)' => dirname($full_path),
        //     '$path' => $path,
        //     '$destination' => $destination,
        //     '$this->folder' => $this->folder,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     // '$stub' => $stub,
        //     // '$destination' => $destination,
        //     // '$searches' => $searches,
        //     '$this->rootNamespace()' => $this->rootNamespace(),
        // ]);

        $this->files->put($full_path, $stub);

        // $this->components->info('The composer.json file was saved: '.$full_path);
        // $this->info('The composer.json file was saved: '.$full_path);
        $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    }

    /**
     * Create the skeleton configuration
     *
     * @param array<string, string> $searches
     */
    protected function createSkeleton(array &$searches): void
    {
        $skeletons = [];

        $skeletons['.editorconfig'] = '.editorconfig';
        $skeletons['.gitattributes'] = '.gitattributes';
        $skeletons['gitignore'] = '.gitignore';
        $skeletons['.php-cs-fixer.dist'] = '.php-cs-fixer.dist';
        $skeletons['CHANGELOG.md'] = 'CHANGELOG.md';

        if ($this->c->package_license() === 'MIT') {
            $skeletons['LICENSE-MIT.md'] = 'LICENSE.md';
            $skeletons['README-MIT.md'] = 'README.md';
        } else {
            $skeletons['README.md'] = 'README.md';
        }

        // $destinationPath = $this->getDestinationPath();

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$full_path' => $full_path,
        //     'dirname($full_path)' => dirname($full_path),
        //     '$path' => $path,
        //     '$destination' => $destination,
        //     '$this->folder' => $this->folder,
        //     '$this->qualifiedName' => $this->qualifiedName,
        //     // '$stub' => $stub,
        //     // '$destination' => $destination,
        //     // '$searches' => $searches,
        //     '$this->rootNamespace()' => $this->rootNamespace(),
        // ]);

        foreach ($skeletons as $skeleton => $file) {

            $path_stub = 'package/'.$skeleton;
            $path = $this->resolveStubPath($path_stub);

            $destination = sprintf(
                '%1$s/%2$s',
                dirname($this->folder()),
                $file
            );
            $stub = $this->files->get($path);

            $this->search_and_replace($stub);

            $full_path = $this->laravel->storagePath().$destination;
            $this->files->put($full_path, $stub);

            $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
        }
    }
}
