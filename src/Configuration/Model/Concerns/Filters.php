<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

use Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Filters
 */
trait Filters
{
    protected ?Model\Filters $filters = null;

    /**
     * @param array<string, mixed> $options
     */
    public function addFilters(array $options): self
    {
        if (! empty($options['filters'])
            && is_array($options['filters'])
        ) {
            $this->filters = new Model\Filters;
            if ($this->skeleton()) {
                $this->filters->withSkeleton();
            }
            $this->filters->setParent($this)->setOptions($options['filters'])->apply();
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$this->filters' => $this->filters,
            //     // '$options[filters]' => $options['filters'],
            //     'json_encode($this->filters)' => json_encode($this->filters, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            // ]);
        }

        return $this;
    }

    public function filters(): ?Model\Filters
    {
        return $this->filters;
    }
}
