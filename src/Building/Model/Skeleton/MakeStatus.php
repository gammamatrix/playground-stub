<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeStatus
 */
trait MakeStatus
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_status = [
        'status' => [
            'type' => 'bigInteger',
            'default' => 0,
            'unsigned' => true,
        ],
        'rank' => [
            'type' => 'bigInteger',
            'default' => 0,
            'unsigned' => false,
        ],
        'size' => [
            'type' => 'bigInteger',
            'default' => 0,
            'unsigned' => false,
        ],
    ];

    protected function buildClass_skeleton_status(Create $create): void
    {
        $status = $create->status();

        $this->components->info(sprintf('Skeleton status for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$status' => $status,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'status' => [],
        ];

        foreach ($this->skeleton_status as $column => $meta) {

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

            $default = null;
            if (array_key_exists('default', $meta)) {
                $default = $meta['default'];
            }

            $this->c->addAttribute($column, $default);

            $this->c->addCast($column, $type);

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['status'])) {
                $addFilters['status'][] = [
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
            if (is_array($this->skeleton_status[$column])) {
                $meta = $this->skeleton_status[$column];
            }

            $meta['label'] = $label;

            $create->addStatus($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
