<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration;

/**
 * \Playground\Stub\Policy
 */
class Policy extends Configuration
{
    protected string $model_fqdn = '';

    /**
     * @var array<int, string>
     */
    protected array $rolesForAction = [];

    /**
     * @var array<int, string>
     */
    protected array $rolesToView = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'class' => '',
        'config' => '',
        'fqdn' => '',
        'model' => '',
        'model_fqdn' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'rolesForAction' => [],
        'rolesToView' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['model_fqdn'])
            && is_string($options['model_fqdn'])
        ) {
            $this->model_fqdn = $options['model_fqdn'];
        }

        if (! empty($options['rolesForAction'])
            && is_array($options['rolesForAction'])
        ) {
            foreach ($options['rolesForAction'] as $role) {
                if ($role && is_string($role)) {
                    $this->addRoleForAction($role);
                }
            }
        }

        if (! empty($options['rolesToView'])
            && is_array($options['rolesToView'])
        ) {
            foreach ($options['rolesToView'] as $role) {
                if ($role && is_string($role)) {
                    $this->addRoleToView($role);
                }
            }
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function rolesForAction(): array
    {
        return $this->rolesForAction;
    }

    public function addRoleForAction(string $role): self
    {
        if ($role && ! in_array($role, $this->rolesForAction)) {
            $this->rolesForAction[] = $role;
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function rolesToView(): array
    {
        return $this->rolesToView;
    }

    public function addRoleToView(string $role): self
    {
        if ($role && ! in_array($role, $this->rolesToView)) {
            $this->rolesToView[] = $role;
        }

        return $this;
    }

    public function model_fqdn(): string
    {
        return $this->model_fqdn;
    }
}
