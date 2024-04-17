<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Stub\Configuration\Swagger\Controller;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Swagger\SwaggerConfiguration;

/**
 * \Playground\Stub\Configuration\Swagger\Controller\PathId
 */
class PathId extends SwaggerConfiguration
{
    /**
     * @var array<int, Parameter>
     */
    protected array $parameters = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'parameters' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['parameters'])
            && is_array($options['parameters'])
        ) {
            foreach ($options['parameters'] as $i => $parameter) {
                if (is_array($parameter)) {
                    $this->addParameter(
                        ! empty($options['name']) && is_string($options['name']) ? $options['name'] : '',
                        $parameter
                    );
                }
            }
        }

        return $this;
    }

    /**
     * @param array<string, mixed> $meta
     */
    public function addParameter(string $name, array $meta = []): self
    {
        if (! empty($meta['name']) && is_string($meta['name'])) {
            if (! empty($name) && $this->skeleton()) {
                if (empty($meta['description']) || ! is_string($meta['description'])) {
                    $meta['description'] = __('playground-stub::swagger.Controller.PathId.Parameter.description', [
                        'name' => Str::of($name)->lower()->singular()->toString(),
                    ]);
                }
            }

            $this->parameters[] = new Parameter($meta, $this->skeleton());
        }

        return $this;
    }

    /**
     * @return array<int, Parameter>
     */
    public function parameters(): array
    {
        return $this->parameters;
    }
}
