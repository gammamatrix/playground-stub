<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

use Illuminate\Support\Facades\Log;

/**
 * \Playground\Stub\Configuration\Model
 */
class Model extends Configuration
{
    use Concerns\Attributes;

    // use Concerns\Filters;
    use Model\Concerns\Relationships;
    use Model\Concerns\Sorting;

    // protected string $extends = 'Model';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
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
        'create' => null,
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

    protected ?Model\Filters $filters = null;

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    protected ?Model\Create $create = null;

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        // ]);
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
        $this->addSorting($options);

        if (! empty($options['create'])
            && is_array($options['create'])
        ) {
            // $this->create = new Model\Create($options['create'], $this->skeleton());
            // $this->create->setParent($this)->apply();
            $this->create = new Model\Create(null, $this->skeleton());
            $this->create->setParent($this)->setOptions($options['create'])->apply();
        }

        if (! empty($options['filters'])
            && is_array($options['filters'])
        ) {
            // $this->filters = new Model\Filters($options['filters'], $this->skeleton());
            // $this->filters->apply();
            // $this->filters->setParent($this)->apply();
            $this->filters = new Model\Filters(null, $this->skeleton());
            $this->filters->setParent($this)->setOptions($options['filters'])->apply();
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->filters' => $this->filters,
            //     // '$options[filters]' => $options['filters'],
            //     'json_encode($this->filters)' => json_encode($this->filters, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            // ]);
        }

        if (! empty($options['scopes'])
            && is_array($options['scopes'])
        ) {
            foreach ($options['scopes'] as $scope => $meta) {
                $this->addScope($scope, $meta);
            }
        }

        if (! empty($options['models'])
            && is_array($options['models'])
        ) {
            foreach ($options['models'] as $key => $file) {
                $this->addMappedClassTo('models', $key, $file);
            }
        }

        return $this;
    }

    public function addScope(
        mixed $scope,
        mixed $meta
    ): self {

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$scope' => $scope,
        //     '$meta' => $meta,
        // ]);
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

        if (in_array($scope, [
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
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$scope' => $scope,
        //     '$options' => $options,
        //     '$this->scopes[$scope]' => $this->scopes[$scope],
        // ]);

        return $this;
    }

    public function create(): ?Model\Create
    {
        return $this->create;
    }

    public function filters(): ?Model\Filters
    {
        return $this->filters;
    }

    /**
     * @return array<string, mixed>
     */
    public function scopes(): array
    {
        return $this->scopes;
    }

    /**
     * @return array<string, mixed>
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return $this->casts;
    }

    /**
     * @return array<int, string>
     */
    public function fillable(): array
    {
        return $this->fillable;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }

    /**
     * @return array<string, class-string>
     */
    public function implements(): array
    {
        return $this->implements;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function factory(): bool
    {
        return $this->factory;
    }

    public function migration(): bool
    {
        return $this->migration;
    }

    public function policy(): bool
    {
        return $this->policy;
    }

    public function seed(): bool
    {
        return $this->seed;
    }

    public function test(): bool
    {
        return $this->test;
    }
}
