<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Concerns;

use Illuminate\Support\Facades\Log;

/**
 * \Playground\Stub\Configuration\Concerns\Sorting
 */
trait Sorting
{
    public function addSortable(
        mixed $scope,
        mixed $meta
    ): self {

        if (empty($scope) || ! is_string($scope)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Scope.invalid', [
                'name' => $this->name,
                'scope' => is_string($scope) ? $scope : gettype($scope),
            ]));
        }

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        Log::warning('IMPLEMENT: '.__METHOD__);

        return $this;
    }
}
