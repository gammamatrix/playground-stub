<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakePermissions
 */
trait MakePermissions
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_permissions = [
        'gids' => [
            'type' => 'tinyInteger',
            'default' => 0,
            'unsigned' => true,
            'icon' => 'fa-solid fa-people-group',
        ],
        'po' => [
            'type' => 'tinyInteger',
            'default' => 0,
            'unsigned' => true,
            'icon' => 'fa-solid fa-house-user',
        ],
        'pg' => [
            'type' => 'tinyInteger',
            'default' => 0,
            'unsigned' => true,
            'icon' => 'fa-solid fa-people-roof',
        ],
        'pw' => [
            'type' => 'tinyInteger',
            'default' => 0,
            'unsigned' => true,
            'icon' => 'fa-solid fa-globe',
        ],
        'only_admin' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-user-gear',
        ],
        'only_user' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-user',
        ],
        'only_guest' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-person-rays',
        ],
        'allow_public' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-users-line',
        ],
    ];

    protected function buildClass_skeleton_permissions(Create $create): void
    {
        $permissions = $create->permissions();

        $this->components->info(sprintf('Skeleton permissions for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$permissions' => $permissions,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'permissions' => [],
        ];

        foreach ($this->skeleton_permissions as $column => $meta) {

            $label = Str::of($column)->replace('_', ' ')->ucfirst()->toString();
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$label' => $label,
            // ]);

            $type = '';
            if (! empty($meta['type']) && is_string($meta['type'])) {
                $type = $meta['type'];
            }

            $default = false;
            if (array_key_exists('default', $meta)) {
                $default = $meta['default'];
            }

            $this->c->addAttribute($column, $default);
            $this->c->addCast($column, $type);
            $this->c->addFillable($column);

            if (! in_array($column, $this->analyze_filters['permissions'])) {
                $addFilters['permissions'][] = [
                    'column' => $column,
                    'type' => $type,
                    'nullable' => true,
                ];
            }

            if (! in_array($column, $this->analyze['sortable'])) {
                $this->c->addSortable([
                    'type' => $type,
                    'column' => $column,
                    'label' => $label,
                ]);
            }

            $meta = [];
            if (is_array($this->skeleton_permissions[$column])) {
                $meta = $this->skeleton_permissions[$column];
            }

            $meta['label'] = $label;

            $create->addPermission($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
