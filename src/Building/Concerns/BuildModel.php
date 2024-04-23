<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Concerns;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Building\Concerns\BuildModel
 */
trait BuildModel
{
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
}
