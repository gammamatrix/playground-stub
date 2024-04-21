<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands\Concerns;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Console\Commands\Concerns\BuildClassTrait
 */
trait BuildingClasses
{
    protected function buildClass_implements(): void
    {
        $use = '';
        $implements = '';

        if (! empty($this->configuration['implements'])
            && is_array($this->configuration['implements'])
        ) {
            $i = 0;
            $count = count($this->configuration['implements']);
            foreach ($this->configuration['implements'] as $key => $value) {
                if (is_string($key)) {
                    if ($key) {
                        $implements .= sprintf(
                            '%1$s%2$s%3$s%4$s',
                            ($count === 1) ? '' : PHP_EOL,
                            ($count === 1) ? ' ' : '    ',
                            $key,
                            (($count !== 1) && ($count - 2) >= $i) ? ',' : ''
                        );
                    }
                    if ($value) {
                        // $this->configuration['uses'][] = ltrim($value, '\\');
                        $this->buildClass_uses_add($value);
                        // $use .= sprintf(
                        //     '%1$suse %2$s;',
                        //     // empty($use) ? '' : PHP_EOL,
                        //     PHP_EOL,
                        //     ltrim($value, '\\')
                        // );
                    }
                }
                $i++;
            }
        }

        // $this->searches['use'] .= $use;
        // $this->searches['use'] = PHP_EOL.trim($this->searches['use']).PHP_EOL;
        $this->searches['implements'] = empty($implements) ? '' : sprintf(
            ' implements%1$s', $implements
        );
    }

    /**
     * @return ?array<string, mixed>
     */
    protected function buildClass_model_meta(
        string $column,
        Model $model
    ): ?array {
        if (empty($model->create())) {
            return null;
        }

        $sections = [
            'ids',
            'dates',
            'permissions',
            'status',
            'ui',
            'flags',
            'columns',
            // 'entity',
            'json',
        ];

        foreach ($sections as $section) {
            if (! empty($model->create()->{$section}())
                && ! empty($model->create()->{$section}()[$column])
            ) {
                return $model->create()->{$section}()[$column]->toArray();
            }
        }

        return null;
    }

    protected function buildClass_model(string $name): void
    {
        $model = '';
        $modelConfiguration = $this->getModelConfiguration();
        if ($modelConfiguration?->name()) {
            $model = $this->parseClassInput(sprintf(
                '%1$s/Models/%2$s',
                rtrim($modelConfiguration->namespace(), '\\/'),
                rtrim($modelConfiguration->name(), '\\/')
            ));
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$name' => $name,
        //     '$model' => $model,
        //     '$this->configurationType' => $this->configurationType,
        //     // '$modelConfiguration' => $modelConfiguration,
        //     '$this->option(model-file)' => $this->option('model-file'),
        //     '$this->searches' => $this->searches,
        // ]);

        if (empty($model) && $this->hasOption('model')) {
            $model = $this->option('model');
            $model = is_string($model) ? $model : '';
        }

        if (empty($model) && ! empty($this->c->model())) {
            $model = $this->c->model();
        }

        if (empty($model) || ! is_string($model)) {
            return;
        }

        $model = str_replace('/', '\\', $model);

        if (str_starts_with($model, '\\')) {
            $namespacedModel = trim($model, '\\');
        } else {
            $namespacedModel = $this->qualifyModel($model);
        }

        $model = class_basename(trim($model, '\\'));

        $userProviderModel = $this->userProviderModel();
        $dummyUser = ! is_string($userProviderModel) ? 'DummyUser' : class_basename($userProviderModel);

        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

        $this->searches['namespacedModel'] = $namespacedModel;
        $this->searches['NamespacedDummyModel'] = $namespacedModel;

        $this->searches['DummyModel'] = $model;
        $this->searches['model'] = $model;
        $this->searches['dummyModel'] = Str::camel($dummyModel);
        $this->searches['modelVariable'] = Str::camel($dummyModel);
        $this->searches['modelSlugPlural'] = Str::of($dummyModel)->camel()->plural()->toString();
        $this->searches['modelVariablePlural'] = Str::of($dummyModel)->camel()->plural()->toString();

        $this->searches['modelLabel'] = Str::of($dummyModel)->title()->toString();

        $this->searches['DummyUser'] = $dummyUser;
        $this->searches['user'] = $dummyUser;
        $this->searches['$user'] = '$'.Str::camel($dummyUser);

        // This could be title like on CMS
        $this->searches['model_attribute'] = 'label';
        $this->searches['model_label'] = $this->searches['modelLabel'];
        $this->searches['model_label_plural'] = Str::of($this->searches['modelLabel'])->plural()->toString();

        if (method_exists($this->c, 'privilege')) {
            $this->searches['module_privilege'] = $this->c->privilege();
        }

        if (array_key_exists('route', $this->searches)) {
            $this->searches['model_route'] = $this->searches['route'];
        }

        $this->searches['model_slug'] = $this->searches['modelVariable'];
        $this->searches['model_slug_plural'] = $this->searches['modelSlugPlural'];
        $this->searches['module_label'] = $this->searches['module'];
        $this->searches['module_label_plural'] = Str::of($this->searches['module'])->plural()->toString();

        if (empty($this->searches['module_route']) && ! empty($this->searches['route'])) {
            $this->searches['module_route'] = Str::of($this->searches['route'])->beforeLast('.')->toString();
        }
        // $this->searches['module_slug'] = $dummyUser;
        // $this->searches['table'] = $dummyUser;
        // $this->searches['view'] = $dummyUser;

        if (empty($this->searches['table']) || ! is_string($this->searches['table'])) {
            if (! empty($this->configuration['table']) && is_string($this->configuration['table'])) {
                $this->searches['table'] = $this->configuration['table'];
            }
            if (empty($this->searches['table'])
                && $modelConfiguration?->table()
            ) {
                $this->searches['table'] = $modelConfiguration->table();
            }
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$model' => $model,
        //     '$this->searches' => $this->searches,
        // ]);
    }

    protected function buildClass_uses_add(string $use, string $use_class = ''): void
    {
        if (empty($use_class)) {
            if (method_exists($this->c, 'addToUse')) {
                $this->c->addToUse($this->parseClassConfig($use));
            }
            // if ($use && ! in_array($use, $this->configuration['uses'])) {
            //     // $this->configuration['uses'][] = ltrim($this->parseClassInput($use), '\\');
            //     // $this->configuration['uses'][] = $this->parseClassInput($use);
            //     $this->configuration['uses'][] = $this->parseClassConfig($use);
            // }
        } else {
            if (method_exists($this->c, 'addToUse')) {
                $this->c->addToUse($this->parseClassConfig($use), $use_class);
            }
            // if (! array_key_exists($use, $this->configuration['uses'])) {
            //     $this->configuration['uses'][$use_class] = ltrim($this->parseClassConfig($use), '/');
            //     $this->configuration['uses'][$use_class] = $this->parseClassInput($use);
            //     $this->configuration['uses'][$use_class] = $this->parseClassConfig($use);
            // }
        }
    }

    protected function buildClass_uses(string $name): void
    {
        $use = '';
        $use_class = '';
        $this->searches['use'] = '';
        $this->searches['use_class'] = '';

        $extends_use = $this->c->extends_use();

        if (! empty($extends_use)) {
            // $this->configuration['uses'][] = ltrim($this->parseClassInput($this->configuration['extends_use']), '\\');
            $this->buildClass_uses_add($extends_use);
        }

        foreach ($this->c->uses() as $key => $value) {
            if (is_string($key)) {
                if ($key) {
                    $use_class .= sprintf(
                        '    use %2$s;%1$s',
                        PHP_EOL,
                        $key
                    );
                }
            }
            if ($value) {
                $use .= sprintf(
                    'use %2$s;%1$s',
                    PHP_EOL,
                    $this->parseClassInput($value)
                );
            }
        }

        // $this->searches['use'] .= $use;
        if (! empty($use)) {
            $this->searches['use'] = PHP_EOL.trim($use).PHP_EOL;
        }
        if (! empty($use_class)) {
            $this->searches['use_class'] = '    '.trim($use_class).PHP_EOL;
        }
        // $this->searches['use'] = PHP_EOL.trim($this->searches['use']).PHP_EOL;

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$this->configuration' => $this->configuration,
        //     // '$this->configuration[extends_use]' => $this->configuration['extends_use'],
        //     '$use' => $use,
        //     '$use_class' => $use_class,
        // ]);

        // $this->searches['use_class'] .= $use_class;
        // if ($this->searches['use_class']) {
        //     $this->searches['use_class'] .= PHP_EOL;
        // }
    }

    protected function createTrait(
        string $folder,
        string $class,
        string $template
    ): void {
        $path = $this->resolveStubPath($template);

        $stub = $this->files->get($path);

        $this->search_and_replace($stub);

        $file = sprintf('%1$s.php', $class);

        $destination = sprintf(
            '%1$s/%2$s',
            $folder,
            $file
        );

        $full_path = $this->laravel->storagePath().$destination;
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->folder()' => $this->folder(),
        //     '$destination' => $destination,
        //     '$full_path' => $full_path,
        // ]);

        $this->files->put($full_path, $stub);

        $this->components->info(sprintf('%s [%s] created successfully.', $file, $full_path));
    }
}
