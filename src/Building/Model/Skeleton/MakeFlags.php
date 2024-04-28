<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeFlags
 */
trait MakeFlags
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_flags = [
        'active' => [
            'type' => 'boolean',
            'default' => true,
            'index' => true,
            'icon' => 'fa-solid fa-person-running',
        ],
        'canceled' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-ban text-warning',
        ],
        'closed' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-xmark',
        ],
        'completed' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-check',
        ],
        'cron' => [
            'type' => 'boolean',
            'default' => false,
            'index' => true,
            'icon' => 'fa-regular fa-clock',
        ],
        // 'duplicate' => [
        //     'type' => 'boolean',
        //     'default' => false,
        //     'icon' => 'fa-solid fa-clone',
        // ],
        // 'fixed' => [
        //     'type' => 'boolean',
        //     'default' => false,
        //     'icon' => 'fa-solid fa-wrench',
        // ],
        'flagged' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-flag',
        ],
        'internal' => [
            'type' => 'boolean',
            'readOnly' => false,
            'default' => false,
            'icon' => 'fa-solid fa-server',
        ],
        'locked' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-lock text-warning',
        ],
        'pending' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-circle-pause text-warning',
        ],
        'planned' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-circle-pause text-success',
        ],
        'problem' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-triangle-exclamation text-danger',
        ],
        // 'published' => [
        //     'type' => 'boolean',
        //     'default' => false,
        //     'icon' => 'fa-solid fa-book',
        // ],
        // 'released' => [
        //     'type' => 'boolean',
        //     'default' => false,
        //     'icon' => 'fa-solid fa-dove',
        // ],
        'retired' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-chair text-success',
        ],
        // 'resolved' => [
        //     'type' => 'boolean',
        //     'default' => false,
        //     'icon' => 'fa-solid fa-check-double text-success',
        // ],
        'suspended' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-hand text-danger',
        ],
        'unknown' => [
            'type' => 'boolean',
            'default' => false,
            'icon' => 'fa-solid fa-question text-warning',
        ],
    ];

    protected function buildClass_skeleton_flags(Create $create): void
    {
        $flags = $create->flags();

        $this->components->info(sprintf('Skeleton flags for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$flags' => $flags,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'flags' => [],
        ];

        foreach ($this->skeleton_flags as $column => $meta) {

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

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['flags'])) {
                $addFilters['flags'][] = [
                    'label' => $label,
                    'column' => $column,
                    'type' => $type,
                    'nullable' => true,
                ];
            }

            if (! in_array($column, $this->analyze['sortable'])) {
                $this->c->addSortable([
                    'label' => $label,
                    'type' => $type,
                    'column' => $column,
                ]);
            }

            $meta = [];
            if (is_array($this->skeleton_flags[$column])) {
                $meta = $this->skeleton_flags[$column];
            }

            $meta['label'] = $label;

            $create->addFlag($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
