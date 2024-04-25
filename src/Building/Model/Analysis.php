<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Analysis
 */
trait Analysis
{
    /**
     * @var array<string, array<int, string>>
     */
    protected array $analyze = [];

    /**
     * @var array<string, array<int, string>>
     */
    protected array $analyze_filters = [];

    public function analyze(Create $create, string $name): void
    {
        $this->components->info(sprintf('Analyzing the [%s] model skeleton configuration', $name));

        $this->analyze_reset($create, $name);
        $this->analyze_attributes($create, $name);
        $this->analyze_casts($create, $name);
        $this->analyze_fillable($create, $name);
        $this->analyze_filters($create, $name);
        $this->analyze_sortable($create, $name);
        $this->analyze_scopes($create, $name);
    }

    protected function analyze_reset(Create $create, string $name): void
    {
        $this->analyze = [
            'attributes' => [],
            'casts' => [],
            'fillable' => [],
            'sortable' => [],
            'scopes' => [],
        ];

        $this->analyze_filters = [
            'ids' => [],
            'dates' => [],
            'flags' => [],
            'trash' => [],
            'status' => [],
            'matrix' => [],
            'permissions' => [],
            'columns' => [],
            'ui' => [],
            'json' => [],
        ];
    }

    protected function analyze_attributes(Create $create, string $name): void
    {
        $attributes = $this->c->attributes();
        $this->components->info(sprintf('Analyzing [ %s ] model [ %d ] attributes', $name, count($attributes)));

        $this->analyze['attributes'] = array_keys($attributes);
        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     '$attributes' => $attributes,
        //     '$this->analyze' => $this->analyze,
        // ]);
    }

    protected function analyze_casts(Create $create, string $name): void
    {
        $casts = $this->c->casts();
        $this->components->info(sprintf('Analyzing [ %s ] model [ %d ] casts', $name, count($casts)));

        $this->analyze['casts'] = array_keys($casts);
        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     '$casts' => $casts,
        //     '$this->analyze' => $this->analyze,
        // ]);
    }

    protected function analyze_fillable(Create $create, string $name): void
    {
        $fillable = $this->c->fillable();
        $this->components->info(sprintf('Analyzing [ %s ] model [ %d ] fillable', $name, count($fillable)));

        $this->analyze['fillable'] = $fillable;
        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     '$fillable' => $fillable,
        //     '$this->analyze' => $this->analyze,
        // ]);
    }

    protected function analyze_filters(Create $create, string $name): void
    {
        $filters = $this->c->filters();
        $this->components->info(sprintf('Analyzing [ %s ] model filters', $name));

        if (! $filters) {
            return;
        }

        // $this->analyze_filters['ids'] = [];

        if (! empty($filters->ids())) {
            // dd([
            //     '__METHOD__' => '__METHOD__',
            //     '$filter' => $filter,
            //     // '$filters' => $filters,
            //     '$this->analyze' => $this->analyze,
            // ]);
            foreach ($filters->ids() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['ids'])) {
                    $this->analyze_filters['ids'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['dates'] = [];

        if (! empty($filters->dates())) {
            foreach ($filters->dates() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['dates'])) {
                    $this->analyze_filters['dates'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['flags'] = [];

        if (! empty($filters->flags())) {
            foreach ($filters->flags() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['flags'])) {
                    $this->analyze_filters['flags'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['trash'] = [];

        // if (!empty($filters['trash'])) {
        //     foreach ($filters['trash'] as $filter) {
        //         if (!in_array($filter->column(), $this->analyze_filters['trash'])) {
        //             $this->analyze_filters['trash'][] = $filter->column();
        //         }
        //         // dd([
        //         //     '__METHOD__' => '__METHOD__',
        //         //     '$filter' => $filter,
        //         //     // '$filters' => $filters,
        //         //     '$this->analyze' => $this->analyze,
        //         // ]);
        //     }
        // }

        // $this->analyze_filters['columns'] = [];

        if (! empty($filters->columns())) {
            foreach ($filters->columns() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['columns'])) {
                    $this->analyze_filters['columns'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     '$filter[permissions]' => $filters->permissions(),
        //     // '$filters' => $filters,
        //     // '$this->analyze' => $this->analyze,
        // ]);
        // $this->analyze_filters['permissions'] = [];

        if (! empty($filters->permissions())) {
            foreach ($filters->permissions() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['permissions'])) {
                    $this->analyze_filters['permissions'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['status'] = [];

        if (! empty($filters->status())) {
            foreach ($filters->status() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['status'])) {
                    $this->analyze_filters['status'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['matrix'] = [];

        if (! empty($filters->matrix())) {
            foreach ($filters->matrix() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['matrix'])) {
                    $this->analyze_filters['matrix'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['ui'] = [];

        if (! empty($filters->ui())) {
            foreach ($filters->ui() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['ui'])) {
                    $this->analyze_filters['ui'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }

        // $this->analyze_filters['json'] = [];

        if (! empty($filters->json())) {
            foreach ($filters->json() as $filter) {
                if (! in_array($filter->column(), $this->analyze_filters['json'])) {
                    $this->analyze_filters['json'][] = $filter->column();
                }
                // dd([
                //     '__METHOD__' => '__METHOD__',
                //     '$filter' => $filter,
                //     // '$filters' => $filters,
                //     '$this->analyze' => $this->analyze,
                // ]);
            }
        }
        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     // '$filters' => $filters,
        //     '$this->analyze' => $this->analyze,
        // ]);
    }

    protected function analyze_sortable(Create $create, string $name): void
    {
        $sortable = $this->c->sortable();
        $this->components->info(sprintf('Analyzing [ %s ] model [ %d ] sortable', $name, count($sortable)));

        foreach ($sortable as $i => $sortable) {
            $this->analyze['sortable'][$i] = $sortable->column();
        }
        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     // '$sortable' => $sortable,
        //     '$this->analyze' => $this->analyze,
        // ]);
    }

    protected function analyze_scopes(Create $create, string $name): void
    {
        $this->components->info(sprintf('Analyzing [ %s ] model: scopes', $name));

        $scopes = $this->c->scopes();
        $this->components->info(sprintf('Analyzing [ %s ] model [ %d ] scopes', $name, count($scopes)));

        foreach ($scopes as $scope => $meta) {
            $this->analyze['scopes'][] = $scope;
        }
        // dd([
        //     '__METHOD__' => '__METHOD__',
        //     '$scopes' => $scopes,
        //     '$this->analyze' => $this->analyze,
        // ]);
    }
}
