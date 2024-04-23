<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Model
 */
class Model extends PrimaryConfiguration
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
        'perPage' => null,
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

    public function apply(): self
    {
        $this->properties['class'] = $this->class();
        $this->properties['config'] = $this->config();
        $this->properties['fqdn'] = $this->fqdn();
        $this->properties['module'] = $this->module();
        $this->properties['module_slug'] = $this->module_slug();
        $this->properties['name'] = $this->name();
        $this->properties['namespace'] = $this->namespace();
        $this->properties['organization'] = $this->organization();
        $this->properties['package'] = $this->package();
        $this->properties['model'] = $this->model();
        $this->properties['model_plural'] = $this->model_plural();
        $this->properties['model_singular'] = $this->model_singular();
        $this->properties['model_slug'] = $this->model_slug();
        $this->properties['type'] = $this->type();
        $this->properties['table'] = $this->table();
        $this->properties['perPage'] = $this->perPage();
        $this->properties['controller'] = $this->controller();
        $this->properties['factory'] = $this->factory();
        $this->properties['migration'] = $this->migration();
        $this->properties['playground'] = $this->playground();
        $this->properties['policy'] = $this->policy();
        $this->properties['requests'] = $this->requests();
        $this->properties['seed'] = $this->seed();
        $this->properties['test'] = $this->test();

        $this->properties['extends'] = $this->extends();
        $this->properties['implements'] = $this->implements();

        if ($this->HasOne()) {
            $this->properties['HasOne'] = [];
            foreach ($this->HasOne() as $method => $HasOne) {
                if (is_array($this->properties['HasOne'])) {
                    $this->properties['HasOne'][$method] = $HasOne->toArray();
                }
            }
        }

        if ($this->HasMany()) {
            $this->properties['HasMany'] = [];
            foreach ($this->HasMany() as $method => $HasMany) {
                if (is_array($this->properties['HasMany'])) {
                    $this->properties['HasMany'][$method] = $HasMany->toArray();
                }
            }
        }

        $this->properties['scopes'] = $this->scopes();
        $this->properties['attributes'] = $this->attributes();
        $this->properties['filters'] = $this->filters()?->toArray();
        $this->properties['models'] = $this->models();
        $this->properties['sortable'] = $this->sortable();

        if ($this->sortable()) {
            $this->properties['sortable'] = [];
            foreach ($this->sortable() as $i => $sortable) {
                if (is_array($this->properties['sortable'])) {
                    $this->properties['sortable'][$i] = $sortable->toArray();
                }
            }
        }

        $this->properties['create'] = $this->create()?->toArray();

        $this->properties['uses'] = $this->uses();

        return $this;
    }

    // public function jsonSerialize(): mixed
    // {

    //     // $properties['components'] = $this->components()->toArray();

    //     // dd([
    //     //     '$properties' => $properties,
    //     // ]);

    //     return $properties;
    // }

    protected string $model = '';

    protected string $model_plural = '';

    protected string $model_singular = '';

    protected string $model_slug = '';

    protected string $type = '';

    protected ?int $perPage = null;

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

        if (array_key_exists('perPage', $options)) {
            $this->perPage = null;
            if (! empty($options['perPage']) && is_numeric($options['perPage']) && $options['perPage'] > 0) {
                $this->perPage = intval($options['perPage']);
            }
        }

        if (! empty($options['model'])
            && is_string($options['model'])
        ) {
            $this->model = $options['model'];
        }

        if (! empty($options['model_plural'])
            && is_string($options['model_plural'])
        ) {
            $this->model_plural = $options['model_plural'];
        }

        if (! empty($options['model_singular'])
            && is_string($options['model_singular'])
        ) {
            $this->model_singular = $options['model_singular'];
        }

        if (! empty($options['model_slug'])
            && is_string($options['model_slug'])
        ) {
            $this->model_slug = $options['model_slug'];
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

    public function perPage(): ?int
    {
        return $this->perPage;
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

    public function model_plural(): string
    {
        return $this->model_plural;
    }

    public function model_singular(): string
    {
        return $this->model_singular;
    }

    public function model_slug(): string
    {
        return $this->model_slug;
    }
}
