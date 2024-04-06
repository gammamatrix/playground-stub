<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

use Illuminate\Support\Facades\Log;

/**
 * \Playground\Stub\Model
 */
class Model extends Configuration
{
    use Concerns\Attributes;
    use Concerns\Filters;
    use Concerns\Relationships;
    use Concerns\Sorting;

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => 'ServiceProvider',
        'config' => '',
        'fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'model' => '',
        'type' => '',
        'table' => '',
        'factory' => true,
        'migration' => true,
        'policy' => false,
        'seed' => false,
        'test' => true,
        // "organization": "GammaMatrix",
        // "package": "playground-matrix",
        // "module": "Matrix",
        // "module_slug": "matrix",
        // "fqdn": "GammaMatrix/Playground/Matrix/Models/Backlog",
        // "namespace": "GammaMatrix/Playground/Matrix",
        // "name": "Backlog",
        // "class": "Backlog",
        // "model": "GammaMatrix/Playground/Matrix/Models/Backlog",
        // "type": "playground-resource",
        // "table": "matrix_backlogs",
        // "extends": "AbstractModel",
        // "implements": [],
        'extends' => '',
        'implements' => [],
        'HasOne' => [],
        'HasMany' => [],
        'scopes' => [],
        'attributes' => [],
        'casts' => [],
        'fillable' => [],
        'filters' => null,
        'models' => [],
        'sortable' => [],
        'create' => [],
        'uses' => [],
    ];

    protected string $model = '';

    protected string $type = '';

    protected string $table = '';

    protected bool $factory = false;

    protected bool $migration = false;

    protected bool $policy = false;

    protected bool $seed = false;

    protected bool $test = false;

    protected string $extends = '';

    /**
     * @var array<string, class-string>
     */
    protected array $implements = [];

    /**
     * @var array<string, array<string, string>>
     */
    protected array $HasOne = [];

    /**
     * @var array<string, array<string, string>>
     */
    protected array $HasMany = [];

    /**
     * @var array<string, mixed>
     */
    protected array $scopes = [];

    /**
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * @var array<string, mixed>
     */
    protected array $casts = [];

    /**
     * @var array<int, string>
     */
    protected array $fillable = [];

    // protected ?Model\Filters $filters = null;

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<string, mixed>
     */
    protected array $sortable = [];

    /**
     * @var array<string, mixed>
     */
    protected array $create = [];

    /**
     * @var array<int, class-string>
     */
    protected array $uses = [];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['model'])
            && is_string($options['model'])
        ) {
            $this->model = $options['model'];
        }

        if (! empty($options['type'])
            && is_string($options['type'])
        ) {
            $this->type = $options['type'];
        }
        if (! empty($options['table'])
            && is_string($options['table'])
        ) {
            $this->table = $options['table'];
        }

        if (array_key_exists('factory', $options)) {
            $this->factory = ! empty($options['factory']);
        }

        if (array_key_exists('migration', $options)) {
            $this->migration = ! empty($options['migration']);
        }

        if (array_key_exists('policy', $options)) {
            $this->policy = ! empty($options['policy']);
        }

        if (array_key_exists('seed', $options)) {
            $this->seed = ! empty($options['seed']);
        }

        if (array_key_exists('test', $options)) {
            $this->test = ! empty($options['test']);
        }

        if (! empty($options['extends'])
            && is_string($options['extends'])
        ) {
            $this->extends = $options['extends'];
        }

        if (! empty($options['implements'])
            && is_array($options['implements'])
        ) {
            foreach ($options['implements'] as $key => $fqdn) {
                $this->addMappedClassTo('implements', $key, $fqdn);
            }
        }

        $this->addRelationships($options);
        $this->addModelProperties($options);

        // if (! empty($options['filters'])
        //     && is_array($options['filters'])
        // ) {
        //     $this->filters = new Models\Filters($options['filters']);
        // }

        if (! empty($options['scopes'])
            && is_array($options['scopes'])
        ) {
            foreach ($options['scopes'] as $scope => $meta) {
                $this->addScope($scope, $meta);
            }
        }

        if (! empty($options['uses'])
            && is_array($options['uses'])
        ) {
            foreach ($options['uses'] as $fqdn) {
                $this->addClassTo('uses', $fqdn);
            }
        }

        if (! empty($options['models'])
            && is_array($options['models'])
        ) {
            foreach ($options['models'] as $key => $file) {
                $this->addMappedClassTo('models', $key, $file);
            }
        }

        if (! empty($options['sortable'])
            && is_array($options['sortable'])
        ) {
            foreach ($options['sortable'] as $method => $meta) {
                $this->addSortable($method, $meta);
            }
        }

        if (! empty($options['create'])
            && is_array($options['create'])
        ) {
            foreach ($options['create'] as $method => $meta) {
                $this->addCreate($method, $meta);
            }
        }

        return $this;
    }

    public function addScope(
        mixed $scope,
        mixed $meta
    ): self {

        if (empty($scope) || ! is_string($scope)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Scope.invalid', [
                'name' => $this->name,
                'scope' => is_string($scope) ? $scope : gettype($scope),
            ]));
        }

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        $supportedScopes = [
            'sort',
        ];

        if (! in_array($scope, $supportedScopes)) {
            Log::warning('playground-stub::stub.Model.Scope.ignored', [
                'name' => $this->name,
                'scope' => $scope,
            ]);

            return $this;
        }

        $options = [];

        if (! in_array($scope, [
            'sort',
        ])) {

            $options['include'] = 'minus';
            $options['builder'] = null;

            if (! empty($meta['include']) && is_string($meta['include'])) {
                $options['include'] = $meta['include'];
            }

            if (! empty($meta['builder']) && is_string($meta['builder'])) {
                $options['builder'] = $meta['builder'];
            }

        }

        $this->scopes[$scope] = $options;

        return $this;
    }

    public function addCreate(
        mixed $scope,
        mixed $meta
    ): self {

        if (empty($scope) || ! is_string($scope)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Scope.invalid', [
                'name' => $this->name,
                'scope' => is_string($scope) ? $scope : gettype($scope),
            ]));
        }

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        Log::warning('IMPLEMENT: '.__METHOD__);

        return $this;
    }
}
