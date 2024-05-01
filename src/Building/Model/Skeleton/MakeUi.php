<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeUi
 */
trait MakeUi
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_ui = [
        'icon' => [
            'type' => 'string',
            'size' => 128,
            'default' => '',
        ],
        'image' => [
            'type' => 'string',
            'default' => '',
            'size' => 512,
        ],
        'avatar' => [
            'type' => 'string',
            'default' => '',
            'size' => 512,
        ],
        'ui' => [
            'default' => '{}',
            'type' => 'JSON_OBJECT',
            'nullable' => true,
        ],
    ];

    protected function buildClass_skeleton_ui(Create $create): void
    {
        $ui = $create->ui();

        $this->components->info(sprintf('Skeleton ui for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$ui' => $ui,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'ui' => [],
        ];

        foreach ($this->skeleton_ui as $column => $meta) {

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

            if (! in_array($column, $this->analyze_filters['ui'])) {
                $addFilters['ui'][] = [
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
            if (is_array($this->skeleton_ui[$column])) {
                $meta = $this->skeleton_ui[$column];
            }

            $meta['label'] = $label;

            $create->addUi($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
