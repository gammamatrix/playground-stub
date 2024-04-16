<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Controller
 */
class Controller extends Configuration
{
    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => 'App',
        'model' => '',
        'organization' => '',
        'package' => 'app',
        'type' => '',
        'models' => [],
        'policies' => [],
        'requests' => [],
        'resources' => [],
        'templates' => [],
        'transformers' => [],
        'extends' => '',
        'extends_use' => '',
        // 'extends' => 'Controller',
        // 'extends_use' => 'App\Http\Controllers\Controller',
        'slug' => '',
        'slug_plural' => '',
        'route' => '',
        'view' => '',
        'uses' => [],
    ];

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<int, string>
     */
    protected array $policies = [];

    /**
     * @var array<int, string>
     */
    protected array $requests = [];

    /**
     * @var array<int, string>
     */
    protected array $resources = [];

    /**
     * @var array<int, string>
     */
    protected array $templates = [];

    /**
     * @var array<int, string>
     */
    protected array $transformers = [];

    protected string $extends = '';

    protected string $extends_use = '';

    protected string $slug = '';

    protected string $slug_plural = '';

    protected string $route = '';

    protected string $view = '';

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }

    /**
     * @return array<int, string>
     */
    public function policies(): array
    {
        return $this->policies;
    }

    /**
     * @return array<int, string>
     */
    public function requests(): array
    {
        return $this->requests;
    }

    /**
     * @return array<int, string>
     */
    public function resources(): array
    {
        return $this->resources;
    }

    /**
     * @return array<int, string>
     */
    public function templates(): array
    {
        return $this->templates;
    }

    /**
     * @return array<int, string>
     */
    public function transformers(): array
    {
        return $this->transformers;
    }

    public function extends(): string
    {
        return $this->extends;
    }

    public function extends_use(): string
    {
        return $this->extends_use;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function slug_plural(): string
    {
        return $this->slug_plural;
    }

    public function route(): string
    {
        return $this->route;
    }

    public function view(): string
    {
        return $this->view;
    }
}
