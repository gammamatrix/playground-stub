<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeDates
 */
trait MakeDates
{
    protected function buildClass_skeleton_timestamps(Create $create): void
    {
        if (! $create->timestamps()) {
            return;
        }

        $this->components->info(sprintf('Adding timestamps to [%s]', $this->c->name()));

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'dates' => [],
        ];

        $this->c->addAttribute('created_at', null);
        $this->c->addCast('created_at', 'datetime');

        if (! in_array('created_at', $this->analyze['sortable'])) {
            $this->c->addSortable([
                'type' => 'string',
                'column' => 'created_at',
                'label' => 'Created At',
            ]);
        }

        if (! in_array('created_at', $this->analyze_filters['dates'])) {
            $addFilters['dates'][] = [
                'label' => 'Created at',
                'column' => 'created_at',
                'type' => 'datetime',
                'nullable' => true,
            ];
        }

        $this->c->addAttribute('updated_at', null);
        $this->c->addCast('updated_at', 'datetime');

        if (! in_array('updated_at', $this->analyze['sortable'])) {
            $this->c->addSortable([
                'type' => 'string',
                'column' => 'updated_at',
                'label' => 'Updated At',
            ]);
        }

        if (! in_array('updated_at', $this->analyze_filters['dates'])) {
            $addFilters['dates'][] = [
                'label' => 'Updated at',
                'column' => 'updated_at',
                'type' => 'datetime',
                'nullable' => true,
            ];
        }

        if ($addFilters) {
            $this->c->addFilter($addFilters);
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$addFilters' => $addFilters,
        //     '$this->c->filters()' => $this->c->filters(),
        // ]);
    }

    protected function buildClass_skeleton_softDeletes(Create $create): void
    {
        if (! $create->softDeletes()) {
            return;
        }

        $this->components->info(sprintf('Adding soft deletes to [%s]', $this->c->name()));

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'dates' => [],
        ];

        $this->c->addAttribute('deleted_at', null);
        $this->c->addCast('deleted_at', 'datetime');

        if (! in_array('deleted_at', $this->analyze_filters['dates'])) {
            $addFilters['dates'][] = [
                'label' => 'Deleted at',
                'column' => 'deleted_at',
                'type' => 'datetime',
                'nullable' => true,
            ];
        }

        if ($addFilters) {
            $this->c->addFilter($addFilters);
        }

        if (! in_array('deleted_at', $this->analyze['sortable'])) {
            $this->c->addSortable([
                'type' => 'string',
                'column' => 'deleted_at',
                'label' => 'Deleted At',
            ]);
        }

    }

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_dates = [
        'start_at' => [
            'nullable' => true,
            'index' => true,
        ],
        'planned_start_at' => [
            'nullable' => true,
            'index' => false,
        ],
        'end_at' => [
            'nullable' => true,
            'index' => true,
        ],
        'planned_end_at' => [
            'nullable' => true,
            'index' => false,
        ],
        'canceled_at' => [
            'nullable' => true,
            'index' => false,
        ],
        'closed_at' => [
            'nullable' => true,
            'index' => true,
        ],
        'embargo_at' => [
            'nullable' => true,
            'index' => false,
        ],
        // 'fixed_at' => [
        //     'nullable' => true,
        //     'index' => false,
        // ],
        'postponed_at' => [
            'nullable' => true,
            'index' => false,
        ],
        // 'published_at' => [
        //     'nullable' => true,
        //     'index' => false,
        // ],
        // 'released_at' => [
        //     'nullable' => true,
        //     'index' => false,
        // ],
        'resumed_at' => [
            'nullable' => true,
            'index' => false,
        ],
        // 'resolved_at' => [
        //     'nullable' => true,
        //     'index' => true,
        // ],
        'suspended_at' => [
            'nullable' => true,
            'index' => false,
        ],
        // 'stop_at' => [
        //     'nullable' => true,
        //     'index' => false,
        // ],
    ];

    protected function buildClass_skeleton_dates(Create $create): void
    {
        $dates = $create->dates();

        $this->components->info(sprintf('Skeleton dates for [%s]', $this->c->name()));

        // $this->components->info(sprintf('Adding dates to [%s]', $this->configuration['name']));
        // $current = array_keys($dates);
        // $skeleton = array_keys($this->skeleton_dates);

        // /**
        //  * @var array<int, string> $add
        //  */
        // $add = [];

        // if ($this->replace) {
        //     $add = array_keys($this->skeleton_dates);
        // } else {
        //     $add = array_diff(array_keys($this->skeleton_dates), $current);
        // }

        // $added = [];
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$dates' => $dates,
        //     '$current' => $current,
        //     // '$add' => $add,
        //     // '$skeleton' => $skeleton,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'dates' => [],
        ];

        foreach ($this->skeleton_dates as $column => $meta) {

            $label = Str::of($column)->replace('_', ' ')->ucfirst()->toString();
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$label' => $label,
            // ]);

            $this->c->addAttribute($column, null);
            $this->c->addCast($column, 'datetime');

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['dates'])) {
                $addFilters['dates'][] = [
                    'column' => $column,
                    'type' => 'datetime',
                    'nullable' => true,
                ];
            }

            if (! in_array($column, $this->analyze['sortable'])) {
                $this->c->addSortable([
                    'type' => 'string',
                    'column' => $column,
                    'label' => $label,
                ]);
            }

            $meta = [];
            if (is_array($this->skeleton_dates[$column])) {
                $meta = $this->skeleton_dates[$column];
            }

            $meta['label'] = $label;

            $create->addDate($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
