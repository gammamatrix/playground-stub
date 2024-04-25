<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeJson
 */
trait MakeJson
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_json = [
        'assets' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'backlog' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'board' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'flow' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'meta' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'notes' => [
            'readOnly' => true,
            'nullable' => true,
            'type' => 'JSON_ARRAY',
            'comment' => 'Array of note objects',
        ],
        'options' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'roadmap' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
        'sources' => [
            'nullable' => true,
            'type' => 'JSON_OBJECT',
        ],
    ];

    protected function buildClass_skeleton_json(Create $create): void
    {
        $json = $create->json();

        $this->components->info(sprintf('Skeleton json for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$json' => $json,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'json' => [],
        ];

        foreach ($this->skeleton_json as $column => $meta) {

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

            if (! in_array($column, $this->analyze_filters['json'])) {
                $addFilters['json'][] = [
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
            if (is_array($this->skeleton_json[$column])) {
                $meta = $this->skeleton_json[$column];
            }

            $meta['label'] = $label;

            $create->addJson($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
