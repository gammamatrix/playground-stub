<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeColumns
 */
trait MakeColumns
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_columns = [
        'label' => [
            'type' => 'string',
            'default' => '',
            'size' => 128,
        ],
        'title' => [
            'type' => 'string',
            'default' => '',
            'size' => 255,
        ],
        'byline' => [
            'type' => 'string',
            'default' => '',
            'size' => 255,
        ],
        'slug' => [
            'type' => 'string',
            'default' => null,
            'size' => 128,
            'index' => true,
            'nullable' => true,
            'slug' => true,
        ],
        'url' => [
            'type' => 'string',
            'default' => '',
            'size' => 512,
        ],
        'description' => [
            'type' => 'string',
            'default' => '',
            'size' => 512,
        ],
        'introduction' => [
            'type' => 'string',
            'default' => '',
            'size' => 512,
        ],
        'content' => [
            'type' => 'mediumText',
            'nullable' => true,
            'html' => true,
        ],
        'summary' => [
            'type' => 'mediumText',
            'nullable' => true,
            'html' => true,
        ],
    ];

    protected function buildClass_skeleton_columns(Create $create): void
    {
        $columns = $create->columns();

        $this->components->info(sprintf('Skeleton columns for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$columns' => $columns,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'columns' => [],
        ];

        foreach ($this->skeleton_columns as $column => $meta) {

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
            $this->c->addFillable($column);

            if (! in_array($column, $this->analyze_filters['columns'])) {
                $addFilters['columns'][] = [
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
            if (is_array($this->skeleton_columns[$column])) {
                $meta = $this->skeleton_columns[$column];
            }

            $meta['label'] = $label;

            $create->addColumn($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
