<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Model
 */
class Model extends Configuration
{
    use Model\Concerns\Attributes;
    use Model\Concerns\Classes;
    use Model\Concerns\Components;
    use Model\Concerns\Creating;
    use Model\Concerns\Filters;
    use Model\Concerns\Relationships;
    use Model\Concerns\Scopes;
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
        'model_plural' => '',
        'model_singular' => '',
        'model_slug' => '',
        'type' => '',
        'table' => '',
        'controller' => false,
        'factory' => false,
        'migration' => false,
        'playground' => false,
        'policy' => false,
        'requests' => false,
        'seed' => false,
        'test' => false,
        // 'organization': 'GammaMatrix',
        // 'package': 'playground-matrix',
        // 'module': 'Matrix',
        // 'module_slug': 'matrix',
        // 'fqdn': 'GammaMatrix/Playground/Matrix/Models/Backlog',
        // 'namespace': 'GammaMatrix/Playground/Matrix',
        // 'name': 'Backlog',
        // 'class': 'Backlog',
        // 'model': 'GammaMatrix/Playground/Matrix/Models/Backlog',
        // 'type': 'playground-resource',
        // 'table': 'matrix_backlogs',
        // 'extends': 'AbstractModel',
        // 'implements': [],
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

    protected bool $playground = false;

    protected string $table = '';

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

        if (array_key_exists('playground', $options)) {
            $this->playground = ! empty($options['playground']);
        }

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

        $this->addExtends($options);
        $this->addComponents($options);
        $this->addImplements($options);
        $this->addRelationships($options);
        $this->addModelProperties($options);
        $this->addSorting($options);
        $this->addScopes($options);
        $this->addFilters($options);
        $this->addModels($options);

        // Create should be called after other options are set.
        if (! empty($options['create'])
            && is_array($options['create'])
        ) {
            $this->addCreate($options);
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    public function playground(): bool
    {
        return $this->playground;
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

    public function table(): string
    {
        return $this->table;
    }

    // public function type(): string
    // {
    //     return $this->type;
    // }
}
