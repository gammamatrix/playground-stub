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
}
