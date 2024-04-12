<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Configuration\Model\Concerns;

use Illuminate\Support\Facades\Log;

/**
 * \Playground\Stub\Configuration\Model\Concerns\Scopes
 */
trait Scopes
{
    /**
     * @var array<string, mixed>
     */
    protected array $scopes = [];

    /**
     * @param array<string, mixed> $options
     */
    public function addScopes(array $options): self
    {
        if (! empty($options['scopes'])
            && is_array($options['scopes'])
        ) {
            foreach ($options['scopes'] as $scope => $meta) {
                $this->addScope($scope, $meta);
            }
        }

        return $this;
    }

    public function addScope(
        mixed $scope,
        mixed $meta
    ): self {

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$scope' => $scope,
        //     '$meta' => $meta,
        // ]);
        if (empty($scope) || ! is_string($scope)) {
            throw new \RuntimeException(__('playground-stub::stub.Model.Scope.invalid', [
                'name' => $this->name,
                'scope' => is_string($scope) ? $scope : gettype($scope),
            ]));
        }

        if (empty($meta) || ! is_array($meta)) {
            $meta = [];
        }

        $supportedScopes = [
            'sort',
        ];

        if (! in_array($scope, $supportedScopes)) {
            Log::warning('playground-stub::stub.Model.Scope.ignored', [
                'name' => $this->name,
                'scope' => $scope,
            ]);

            return $this;
        }

        $options = [];

        if (in_array($scope, [
            'sort',
        ])) {

            $options['include'] = 'minus';
            $options['builder'] = null;

            if (! empty($meta['include']) && is_string($meta['include'])) {
                $options['include'] = $meta['include'];
            }

            if (! empty($meta['builder']) && is_string($meta['builder'])) {
                $options['builder'] = $meta['builder'];
            }

        }

        $this->scopes[$scope] = $options;
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$scope' => $scope,
        //     '$options' => $options,
        //     '$this->scopes[$scope]' => $this->scopes[$scope],
        // ]);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function scopes(): array
    {
        return $this->scopes;
    }
}
