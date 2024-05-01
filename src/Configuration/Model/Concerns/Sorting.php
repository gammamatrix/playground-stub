<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

use Playground\Stub\Configuration\Model\Sortable;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Sorting
 */
trait Sorting
{
    /**
     * @var array<int, Sortable>
     */
    protected array $sortable = [];

    /**
     * @param array<string, mixed> $options
     */
    public function addSorting(array $options): self
    {
        if (! empty($options['sortable'])
            && is_array($options['sortable'])
        ) {
            foreach ($options['sortable'] as $i => $meta) {
                $this->addSortable($meta, $i);
                // $this->sortable[$i] = new Sortable($meta, $this->skeleton());
                // $this->sortable[$i]->apply();
                // $this->sortable[$i] = new Sortable(null, $this->skeleton());
                // $this->sortable[$i]->setParent($this)->setOptions($meta)->apply();
            }
        }

        return $this;
    }

    public function addSortable(
        mixed $meta,
        int $i = null
    ): self {

        if (empty($meta)
            || ! is_array($meta)
            || empty($meta['column'])
            || ! is_string($meta['column'])
        ) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Sorting.invalid', [
                'name' => $this->name() ?: 'model',
                'i' => $i ?? '-',
            ]));
        }

        $sortable = new Sortable;
        $sortable->setParent($this)->setOptions($meta)->apply();

        if (is_numeric($i)) {
            $this->sortable[$i] = $sortable;
        } else {
            $this->sortable[] = $sortable;
        }

        return $this;
    }

    /**
     * @return array<int, Sortable>
     */
    public function sortable(): array
    {
        return $this->sortable;
    }
}
