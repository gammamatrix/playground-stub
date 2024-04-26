<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeIds
 */
trait MakeIds
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_ids_users = [
        'created_by_id' => [
            'type' => 'uuid',
            'readOnly' => true,
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'users',
            ],
            'trait' => 'WithCreator',
        ],
        'modified_by_id' => [
            'type' => 'uuid',
            'readOnly' => true,
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'users',
            ],
            'trait' => 'WithModifier',
        ],
        'owned_by_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'users',
            ],
            'trait' => 'WithOwner',
        ],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_ids_model = [
        'parent_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => null,
            ],
            'trait' => 'WithParent',
        ],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_ids_package = [
        // 'backlog_id' => [
        //     'type' => 'uuid',
        //     'nullable' => true,
        //     'index' => true,
        //     'foreign' => [
        //         'references' => 'id',
        //         'on' => 'matrix_backlogs',
        //     ],
        // ],
        'board_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_boards',
            ],
        ],
        // 'completed_by_id' => [
        //     'type' => 'uuid',
        //     'nullable' => true,
        //     'index' => true,
        //     'foreign' => [
        //         'references' => 'id',
        //         'on' => 'users',
        //     ],
        // ],
        // 'duplicate_id' => [
        //     'type' => 'uuid',
        //     'nullable' => true,
        //     'index' => true,
        //     'foreign' => [
        //         'references' => 'id',
        //         'on' => 'matrix_tickets',
        //     ],
        // ],
        'epic_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_epics',
            ],
        ],
        // 'fixed_by_id' => [
        //     'type' => 'uuid',
        //     'nullable' => true,
        //     'index' => true,
        //     'foreign' => [
        //         'references' => 'id',
        //         'on' => 'users',
        //     ],
        // ],
        'flow_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_flows',
            ],
        ],
        'matrix_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_matrices',
            ],
        ],
        'milestone_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_milestones',
            ],
        ],
        'note_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_notes',
            ],
        ],
        'project_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_projects',
            ],
        ],
        'release_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_releases',
            ],
        ],
        // 'reported_by_id' => [
        //     'type' => 'uuid',
        //     'nullable' => true,
        //     'index' => true,
        //     'foreign' => [
        //         'references' => 'id',
        //         'on' => 'users',
        //     ],
        // ],
        'roadmap_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_roadmaps',
            ],
        ],
        'source_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_sources',
            ],
        ],
        'sprint_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_sprints',
            ],
        ],
        'tag_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_tags',
            ],
        ],
        'team_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_teams',
            ],
        ],
        'ticket_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_tickets',
            ],
        ],
        // 'version_fixed_id' => [
        //     'type' => 'uuid',
        //     'nullable' => true,
        //     'index' => true,
        //     'foreign' => [
        //         'references' => 'id',
        //         'on' => 'matrix_versions',
        //     ],
        // ],
        'version_id' => [
            'type' => 'uuid',
            'nullable' => true,
            'index' => true,
            'foreign' => [
                'references' => 'id',
                'on' => 'matrix_versions',
            ],
        ],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $skeleton_ids = [
    ];

    protected function buildClass_skeleton_ids(Create $create): void
    {
        $this->buildClass_skeleton_ids_users($create);
        $this->buildClass_skeleton_ids_model($create);
        $this->buildClass_skeleton_ids_package($create);
    }

    protected function buildClass_skeleton_ids_users(Create $create): void
    {
        $ids = $create->ids();

        $this->components->info(sprintf('Skeleton ids for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$ids' => $ids,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'ids' => [],
        ];

        foreach ($this->skeleton_ids_users as $column => $meta) {

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

            // TODO Should we add a custom scalar type?
            // $type = 'scalar';
            // @see $primitiveCastTypes in vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php

            if (! in_array($type, [
                'uuid',
            ])) {
                $this->c->addCast($column, $type);
            }

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['ids'])) {
                $addFilters['ids'][] = [
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
            if (is_array($this->skeleton_ids_users[$column])) {
                $meta = $this->skeleton_ids_users[$column];
            }

            $meta['label'] = $label;

            $create->addId($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }

            $foreign = ! empty($meta['foreign']) && is_array($meta['foreign']) ? $meta['foreign'] : [];

            if ($this->no_user_hasOne || empty($foreign)) {
                continue;
            }

            $accessor = Str::of($column)->before('_id')->studly()->lcfirst()->toString();

            $related = Str::of($column)->before('_id')->studly()->toString();

            $foreignKey = $foreign['references'] ?? 'id';

            $addOne = [
                // 'comment' => '',
                // 'accessor' => '',
                'related' => $related,
                'foreignKey' => $foreignKey,
                'localKey' => $column,
            ];

            $this->c->addHasOne($accessor, $addOne);
        }
    }

    protected bool $no_user_hasOne = true;

    protected bool $model_has_type = true;

    protected function buildClass_skeleton_ids_model(Create $create): void
    {
        $ids = $create->ids();

        $this->components->info(sprintf('Skeleton ids for [%s]', $this->c->name()));

        if ($this->model_has_type) {
            $type_column = Str::of($this->c->name())->snake()->finish('_type')->toString();
            $this->skeleton_ids_model[$type_column] = [
                'type' => 'string',
                'nullable' => true,
                'index' => true,
            ];
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$ids' => $ids,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'ids' => [],
        ];

        foreach ($this->skeleton_ids_model as $column => $meta) {

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

            if (! in_array($type, [
                'uuid',
            ])) {
                $this->c->addCast($column, $type);
            }

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['ids'])) {
                $addFilters['ids'][] = [
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
            if (is_array($this->skeleton_ids_model[$column])) {
                $meta = $this->skeleton_ids_model[$column];
            }

            $meta['label'] = $label;

            $create->addId($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }

    protected bool $buildClass_skeleton_ids_package_allow_self = false;

    protected function buildClass_skeleton_ids_package(Create $create): void
    {
        $ids = $create->ids();

        $this->components->info(sprintf('Skeleton ids for [%s]', $this->c->name()));

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$ids' => $ids,
        // ]);

        /**
         * @var array<string, array<int, mixed>>
         */
        $addFilters = [
            'ids' => [],
        ];

        foreach ($this->skeleton_ids_package as $column => $meta) {

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

            if (! in_array($type, [
                'uuid',
            ])) {
                $this->c->addCast($column, $type);
            }

            if (empty($meta['readOnly'])) {
                $this->c->addFillable($column);
            }

            if (! in_array($column, $this->analyze_filters['ids'])) {
                $addFilters['ids'][] = [
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
            if (is_array($this->skeleton_ids_package[$column])) {
                $meta = $this->skeleton_ids_package[$column];
            }

            $meta['label'] = $label;

            $create->addId($column, $meta);

            if ($addFilters) {
                $this->c->addFilter($addFilters);
            }
        }
    }
}
