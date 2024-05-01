<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeMatrix
 */
trait MakeMatrix
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_matrix = [
        'matrix' => [
            'column' => 'matrix',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => '{}',
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'JSON_OBJECT',
        ],
        'x' => [
            'column' => 'x',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'bigInteger',
            'unsigned' => false,
        ],
        'y' => [
            'column' => 'y',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'bigInteger',
            'unsigned' => false,
        ],
        'z' => [
            'column' => 'z',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'bigInteger',
            'unsigned' => false,
        ],
        'r' => [
            'column' => 'r',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 65,
            'scale' => 10,
        ],
        'theta' => [
            'column' => 'theta',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 10,
            'scale' => 6,
        ],
        'rho' => [
            'column' => 'rho',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 10,
            'scale' => 6,
        ],
        'phi' => [
            'column' => 'phi',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 10,
            'scale' => 6,
        ],
        'elevation' => [
            'column' => 'elevation',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 65,
            'scale' => 10,
        ],
        'latitude' => [
            'column' => 'latitude',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 8,
            'scale' => 6,
        ],
        'longitude' => [
            'column' => 'longitude',
            'label' => '',
            'description' => '',
            'icon' => '',
            'default' => null,
            'index' => false,
            'nullable' => true,
            'readOnly' => false,
            'type' => 'decimal',
            'precision' => 9,
            'scale' => 6,
        ],
    ];

    protected function buildClass_skeleton_matrix(Create $create): void
    {
        $matrix = $create->matrix();

        $this->components->info(sprintf('Skeleton matrix for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$matrix' => $matrix,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'matrix' => [],
        ];

        foreach ($this->skeleton_matrix as $column => $meta) {

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

            $this->c->addCast(
                $column,
                $type === 'decimal' ? 'float' : $type
            );

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['matrix'])) {
                $addFilters['matrix'][] = [
                    'label' => $label,
                    'column' => $column,
                    'type' => $type,
                    'nullable' => true,
                ];
            }

            if (! in_array($column, $this->analyze['sortable'])) {
                $this->c->addSortable([
                    'label' => $label,
                    'type' => $type === 'decimal' ? 'float' : $type,
                    'column' => $column,
                ]);
            }

            $meta = [];
            if (is_array($this->skeleton_matrix[$column])) {
                $meta = $this->skeleton_matrix[$column];
            }

            $meta['label'] = $label;

            $create->addMatrix($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
